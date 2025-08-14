<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class BillingController extends Controller
{
    /**
     * Pantalla principal de facturación (manager).
     */
    public function index(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        $selectedClientId = $request->get('client_id');

        // Clients: SIEMPRE con paginator para que la vista pueda usar firstItem(), links(), etc.
        $clients = \App\Models\Client::query()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($w) use ($query) {
                    $w->where('nombre', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('dni', 'like', "%{$query}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(20)
            ->withQueryString();

        $selectedClient = null;

        if ($selectedClientId) {
            // OJO: en tu esquema la FK del contrato al cliente es "cliente_id"
            $selectedClient = \App\Models\Client::with(['contracts.plan'])->find($selectedClientId);
        }

        // Invoices: paginator o vacío si no hay cliente seleccionado
        if ($selectedClient) {
            $invoices = \App\Models\Invoice::with(['payments', 'contract.plan'])
                ->whereHas('contract', fn($q) => $q->where('cliente_id', $selectedClient->id)) // <- cliente_id
                ->orderByDesc('fecha_emision')
                ->paginate(15)
                ->withQueryString();
        } else {
            $invoices = new \Illuminate\Pagination\LengthAwarePaginator(
                items: [],
                total: 0,
                perPage: 15,
                currentPage: 1,
                options: [
                    'path'  => $request->url(),
                    'query' => $request->query(),
                ]
            );
        }

        // ====== NUEVO: estadísticas para la tarjeta de "stats" en la vista ======
        $start = \Carbon\Carbon::now()->startOfMonth();
        $end   = \Carbon\Carbon::now()->endOfMonth();

        // Stats globales por defecto
        $revenueThisMonth = \App\Models\Payment::whereBetween('fecha_pago', [$start->toDateString(), $end->toDateString()])
            ->sum('monto_pagado');

        $pendingInvoicesQuery = \App\Models\Invoice::query()->where('estado', 'Pendiente');

        $stats = [
            'revenue_this_month'     => (float) $revenueThisMonth,
            'pending_invoices_count' => (int) $pendingInvoicesQuery->count(),
            'total_pending_amount'   => (float) $pendingInvoicesQuery->sum('monto'),
            'paid_invoices_this_month' => (int) \App\Models\Invoice::where('estado', 'Pagada')
                ->whereBetween('fecha_emision', [$start->toDateString(), $end->toDateString()])
                ->count(),
        ];

        // Si querés que las stats se filtren POR cliente cuando hay uno seleccionado:
        if ($selectedClient) {
            $revenueThisMonth = \App\Models\Payment::whereBetween('fecha_pago', [$start->toDateString(), $end->toDateString()])
                ->whereHas('invoice.contract', function ($q) use ($selectedClient) {
                    $q->where('cliente_id', $selectedClient->id); // <- cliente_id
                })
                ->sum('monto_pagado');

            $pendingForClient = \App\Models\Invoice::where('estado', 'Pendiente')
                ->whereHas('contract', function ($q) use ($selectedClient) {
                    $q->where('cliente_id', $selectedClient->id); // <- cliente_id
                });

            $stats = [
                'revenue_this_month'       => (float) $revenueThisMonth,
                'pending_invoices_count'   => (int) $pendingForClient->count(),
                'total_pending_amount'     => (float) $pendingForClient->sum('monto'),
                'paid_invoices_this_month' => (int) \App\Models\Invoice::where('estado', 'Pagada')
                    ->whereBetween('fecha_emision', [$start->toDateString(), $end->toDateString()])
                    ->whereHas('contract', function ($q) use ($selectedClient) {
                        $q->where('cliente_id', $selectedClient->id); // <- cliente_id
                    })
                    ->count(),
            ];
        }
        // ====== FIN stats ======

        return view('billing.manager.index', [
            'clients'        => $clients,
            'selectedClient' => $selectedClient,
            'invoices'       => $invoices,
            'q'              => $query,
            'stats'          => $stats, // <- IMPORTANTE
        ]);
    }


    /**
     * Formulario para generar un cobro a un cliente.
     */
    public function createInvoice(Client $client)
    {
        // Ajustá el filtro de estado si tu modelo usa otros nombres
        $contracts = \App\Models\Contract::with('plan')
            ->where('cliente_id', $client->id)
            ->when(\Illuminate\Support\Facades\Schema::hasColumn('contracts', 'status'), function ($q) {
                $q->where('status', 'Activo');
            })
            ->get();

        return view('billing.manager.create-invoice', [
            'client'    => $client,
            'contracts' => $contracts,
        ]);
    }

    /**
     * Guarda un cobro (factura + pago) y genera el recibo PDF.
     */
    public function storeInvoice(Request $request, Client $client)
    {
        $validated = $request->validate([
            'contract_id'  => 'required|exists:contracts,id',
            'mes_servicio' => 'required|date_format:Y-m',
            'monto_pagado' => 'required|numeric|min:0.01',
            'metodo_pago'  => 'required|string|max:50',
            'fecha_pago'   => 'required|date',
            'notas'        => 'nullable|string|max:2000',
        ]);

        DB::beginTransaction();
        try {
            $fechaEmision     = Carbon::now();
            $fechaVencimiento = Carbon::parse($validated['mes_servicio'] . '-01')->endOfMonth();

            $invoice = Invoice::create([
                'contrato_id'      => $validated['contract_id'],
                'monto'            => $validated['monto_pagado'],
                'fecha_emision'    => $fechaEmision->toDateString(),
                'fecha_vencimiento' => $fechaVencimiento->toDateString(),
                'estado'           => 'Pagada',
                'pdf_filename'     => null, // se completa luego
            ]);

            $payment = Payment::create([
                'factura_id'   => $invoice->id,
                'fecha_pago'   => Carbon::parse($validated['fecha_pago'])->toDateString(),
                'monto_pagado' => $validated['monto_pagado'],
                'metodo_pago'  => $validated['metodo_pago'],
                'notas'        => $validated['notas'] ?? null,
            ]);

            // Generar PDF
            $invoice->load(['contract.client', 'contract.plan', 'payments']);
            $client->loadMissing('contracts.plan');

            $pdf = Pdf::loadView('pdf.receipt', [
                'invoice'  => $invoice,
                'payment'  => $payment,
                'client'   => $client,
                'contract' => $invoice->contract,
            ]);

            // Guardar PDF
            $filename = 'recibo-' . $invoice->id . '-' . time() . '.pdf';
            Storage::disk('local')->put('receipts/' . $filename, $pdf->output());

            // Vincular el archivo a la factura
            if (schema_has_column('invoices', 'pdf_filename')) {
                $invoice->update(['pdf_filename' => $filename]);
            }

            DB::commit();

            return redirect()
                ->route('billing.index', ['client_id' => $client->id])
                ->with('success', '¡Cobro registrado y recibo PDF generado exitosamente!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Error al registrar el cobro: ' . $e->getMessage())
                ->withInput();
        }
    }
}

/**
 * Helper chiquito para evitar errores si cambian columnas entre entornos.
 */
if (! function_exists('schema_has_column')) {
    function schema_has_column(string $table, string $column): bool
    {
        try {
            return \Illuminate\Support\Facades\Schema::hasColumn($table, $column);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
