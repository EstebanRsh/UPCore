<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Imports para el PDF
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
        $searchTerm = $request->input('search');
        $clients = null;
        $selectedClient = null;

        if ($searchTerm) {
            $clients = Client::with('user')
                ->where('nombre', 'like', "%{$searchTerm}%")
                ->orWhere('apellido', 'like', "%{$searchTerm}%")
                ->orWhere('dni_cuit', 'like', "%{$searchTerm}%")
                ->get();
        }

        if ($request->has('client_id')) {
            $selectedClient = Client::with([
                'user',
                'contracts.plan',
                'contracts.invoices' => function ($query) {
                    $query->where('estado', 'Pendiente');
                }
            ])->find($request->client_id);
        }

        return view('billing.index', [
            'clients' => $clients,
            'searchTerm' => $searchTerm,
            'selectedClient' => $selectedClient,
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva factura y registrar un pago manualmente.
     */
    public function createInvoice(Client $client)
    {
        $contracts = $client->contracts()->where('estado', 'Activo')->with('plan')->get();
        return view('billing.create-invoice', [
            'client' => $client,
            'contracts' => $contracts,
        ]);
    }

    /**
     * Guarda una nueva factura, su pago correspondiente y genera el recibo en PDF.
     */
    public function storeInvoice(Request $request, Client $client)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'mes_servicio' => 'required|date_format:Y-m',
            'monto_pagado' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|string', // <-- CORREGIDO
            'fecha_pago' => 'required|date',
        ]);

        $contract = Contract::find($validated['contract_id']);
        $serviceMonth = Carbon::parse($validated['mes_servicio']);
        $invoice = null;

        try {
            $invoice = DB::transaction(function () use ($validated, $contract, $serviceMonth) {
                // 1. Creamos la Factura
                $newInvoice = Invoice::create([
                    'contract_id' => $contract->id,
                    'monto' => $validated['monto_pagado'],
                    'fecha_emision' => $serviceMonth->startOfMonth(),
                    'fecha_vencimiento' => $serviceMonth->endOfMonth(),
                    'estado' => 'Pagada',
                ]);

                // 2. Creamos el Pago asociado
                $newInvoice->payments()->create([
                    'monto_pagado' => $validated['monto_pagado'],
                    'metodo_pago' => $validated['metodo_pago'],
                    'fecha_pago' => $validated['fecha_pago'],
                ]);

                return $newInvoice;
            });

            // --- LÓGICA DEL PDF (SOLO SE EJECUTA SI LA TRANSACCIÓN FUE EXITOSA) ---
            $invoice->load('contract.client.user', 'contract.plan', 'contract.serviceAddress', 'payments');
            $payment = $invoice->payments->first();
            $pdf = Pdf::loadView('pdf.receipt', ['invoice' => $invoice, 'payment' => $payment]);
            $filename = 'recibo-' . $invoice->id . '-' . time() . '.pdf';
            Storage::put('private/receipts/' . $filename, $pdf->output());

            return redirect()->route('billing.index', ['client_id' => $client->id])
                ->with('success', '¡Cobro registrado y recibo PDF generado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al registrar el cobro: ' . $e->getMessage())->withInput();
        }
    }
}
