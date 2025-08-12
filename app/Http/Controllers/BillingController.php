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
        $searchTerm = $request->input('search');
        $clients = null;
        $selectedClient = null;

        if ($searchTerm) {
            $clients = Client::with('user')
                ->where('nombre', 'like', "%{$searchTerm}%")
                ->orWhere('apellido', 'like', "%{$searchTerm}%")
                ->orWhere('dni_cuit', 'like', "%{$searchTerm}%")
                ->limit(10)
                ->get();
        }

        // Si se ha seleccionado un cliente (haciendo clic en un resultado de búsqueda)
        if ($request->has('client_id')) {
            $selectedClient = Client::with(['user', 'contracts.plan', 'invoices' => function ($query) {
                $query->orderBy('fecha_emision', 'desc');
            }])->find($request->client_id);
        }

        // Lógica para los Widgets
        $latestPayments = Payment::with('invoice.contract.client')
            ->latest('fecha_pago') // Ordena por la fecha de pago más reciente
            ->limit(5)
            ->get();

        $pendingInvoices = Invoice::with('contract.client')
            ->where('estado', 'Pendiente')
            ->orderBy('fecha_vencimiento', 'asc') // Muestra las deudas más antiguas primero
            ->limit(5)
            ->get();

        return view('billing.manager.index', compact(
            'clients',
            'searchTerm',
            'selectedClient',
            'latestPayments',
            'pendingInvoices'
        ));
    }

    /**
     * Muestra el formulario para generar un nuevo cobro.
     */
    public function createInvoice(Client $client)
    {
        $contracts = $client->contracts()->where('estado', 'Activo')->with('plan')->get();
        return view('billing.manager.create-invoice', [
            'client' => $client,
            'contracts' => $contracts,
        ]);
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
