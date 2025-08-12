<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class BillingController extends Controller
{
    /**
     * Muestra la página principal de facturación, busca clientes
     * y muestra el estado de cuenta del cliente seleccionado.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $searchTerm = $request->input('search');
        $city = $request->input('city');
        // Añadimos valores por defecto para el ordenamiento
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $clients = Client::query()
            ->with(['payments' => fn($q) => $q->latest('fecha_pago')->limit(1)])
            ->when($searchTerm, function ($query, $term) {
                return $query->where(function ($q) use ($term) {
                    $q->where('nombre', 'like', "%{$term}%")
                        ->orWhere('apellido', 'like', "%{$term}%")
                        ->orWhere('dni_cuit', 'like', "%{$term}%");
                });
            })
            // ¡NUEVO! Aplicamos el filtro de ciudad si existe
            ->when($city, function ($query, $cityTerm) {
                return $query->whereHas('serviceAddresses', fn($q) => $q->where('ciudad', 'like', "%{$cityTerm}%"));
            })
            // ¡NUEVO! Aplicamos el ordenamiento
            ->orderBy($sortBy, $sortDirection)
            ->paginate(5);

        // La lógica de estadísticas no cambia
        $stats = [
            'revenue_this_month' => Payment::whereMonth('fecha_pago', Carbon::now()->month)->sum('monto_pagado'),
            'pending_invoices_count' => Invoice::where('estado', 'Pendiente')->count(),
            'total_pending_amount' => Invoice::where('estado', 'Pendiente')->sum('monto'),
            'payments_today' => Payment::whereDate('fecha_pago', Carbon::today())->count(),
        ];

        return view('billing.manager.index', compact('clients', 'filters', 'stats'));
    }

    /**
     * Muestra el formulario (dentro del modal) para generar un nuevo cobro.
     */
    public function createInvoice(Client $client)
    {
        $contracts = $client->contracts()->where('estado', 'Activo')->with('plan')->get();
        // Esta función ahora podría devolver una vista parcial para el modal
        // o la usaremos para poblar el modal con datos.
    }


    /**
     * Guarda un nuevo cobro (factura + pago) y genera el recibo en PDF.
     */
    public function storeInvoice(Request $request, Client $client)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'mes_servicio' => 'required|date_format:Y-m',
            'monto_pagado' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
        ]);

        $contract = Contract::find($validated['contract_id']);
        $serviceMonth = Carbon::parse($validated['mes_servicio']);

        try {
            // Usamos una transacción para asegurar que todo se ejecute correctamente
            $invoice = DB::transaction(function () use ($validated, $contract, $serviceMonth) {
                // 1. Creamos la Factura con estado 'Pagada'
                $newInvoice = Invoice::create([
                    'contrato_id' => $contract->id,
                    'monto' => $validated['monto_pagado'],
                    'fecha_emision' => $serviceMonth->startOfMonth(),
                    'fecha_vencimiento' => $serviceMonth->endOfMonth(),
                    'estado' => 'Pagada',
                ]);

                // 2. Creamos el Pago asociado a esa factura
                $newInvoice->payments()->create([
                    'monto_pagado' => $validated['monto_pagado'],
                    'metodo_pago' => $validated['metodo_pago'],
                    'fecha_pago' => $validated['fecha_pago'],
                ]);

                return $newInvoice;
            });

            // 3. Generamos el PDF si todo salió bien
            $invoice->load('contract.client.user', 'contract.plan', 'contract.serviceAddress', 'payments');
            $payment = $invoice->payments->first(); // Obtenemos el pago que acabamos de crear

            $pdf = Pdf::loadView('pdf.receipt', ['invoice' => $invoice, 'payment' => $payment]);
            $filename = 'recibo-' . $invoice->id . '-' . time() . '.pdf';

            // Guardamos el PDF en el disco 'local' (storage/app/private/receipts)
            Storage::disk('local')->put('receipts/' . $filename, $pdf->output());

            return redirect()->route('billing.manager.index', ['client_id' => $client->id])
                ->with('success', '¡Cobro registrado y recibo PDF generado exitosamente!');
        } catch (\Exception $e) {
            // Si algo falla, volvemos al formulario con un error
            return redirect()->back()
                ->with('error', 'Hubo un error al registrar el cobro: ' . $e->getMessage())
                ->withInput();
        }
    }
}
