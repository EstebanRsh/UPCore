<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Muestra el formulario para registrar un pago para una factura.
     */
    public function create(Invoice $invoice)
    {
        $invoice->load('contract.client', 'contract.plan');
        return view('payments.create', ['invoice' => $invoice]);
    }

    /**
     * Guarda el pago, actualiza la factura y reactiva el contrato si es necesario.
     */
    public function store(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'monto_pagado' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|string|max:255',
            'fecha_pago' => 'required|date',
            'notas' => 'nullable|string',
        ]);

        // Usamos una transacción para garantizar la integridad de los datos
        DB::transaction(function () use ($validated, $invoice) {
            // 1. Creamos el pago asociado a la factura
            $invoice->payments()->create($validated);

            // 2. Actualizamos el estado de la factura a 'Pagada'
            // (Para simplificar, asumimos que siempre se paga el total)
            $invoice->update(['estado' => 'Pagada']);

            // 3. Lógica de Reactivación del Servicio
            $contract = $invoice->contract;

            // Si el contrato estaba suspendido...
            if ($contract->estado === 'Suspendido') {
                // Contamos cuántas otras facturas de este contrato siguen pendientes
                $pendingInvoicesCount = $contract->invoices()->where('estado', 'Pendiente')->count();

                // Si ya no quedan facturas pendientes, reactivamos el contrato
                if ($pendingInvoicesCount === 0) {
                    $contract->update(['estado' => 'Activo']);
                }
            }
        });

        // Redirigimos de vuelta a la página de facturación del cliente
        $clientId = $invoice->contract->client->id;
        return redirect()->route('billing.index', ['client_id' => $clientId])
            ->with('success', '¡Pago registrado exitosamente!');
    }
}
