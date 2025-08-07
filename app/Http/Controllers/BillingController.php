<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\PrepaidPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Promotion;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $clients = null;
        $selectedClient = null;
        $promotions = Promotion::where('activa', true)->get();
        // Si hay un término de búsqueda, buscamos en la base de datos
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
                // Cargamos solo las facturas con estado 'Pendiente' de cada contrato
                'contracts.invoices' => function ($query) {
                    $query->where('estado', 'Pendiente');
                }
            ])->find($request->client_id);
        }

        return view('billing.index', [
            'clients' => $clients,
            'searchTerm' => $searchTerm,
            'selectedClient' => $selectedClient,
            'promotions' => $promotions,
        ]);
    }
    public function processAdvancedPayment(Request $request)
    {
        // 1. Validamos los datos básicos del formulario
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'contract_id' => 'required|exists:contracts,id',
            'promotion_id' => 'nullable|exists:promotions,id',
            'meses_a_pagar' => 'required_without:promotion_id|integer|min:1',
        ]);

        $contract = Contract::with('plan')->find($request->contract_id);
        $totalAPagar = 0;
        $mesesDuracion = 0;
        $precioCongelado = $contract->plan->precio_mensual;

        // 2. Calculamos el total dependiendo si se usó una promo o un pago manual
        if ($request->filled('promotion_id')) {
            $promo = Promotion::find($request->promotion_id);
            $mesesDuracion = $promo->duracion_meses;
            $precioBaseTotal = $precioCongelado * $mesesDuracion;

            switch ($promo->tipo_descuento) {
                case 'porcentaje':
                    $totalAPagar = $precioBaseTotal * (1 - ($promo->valor_descuento / 100));
                    $precioCongelado = $totalAPagar / $mesesDuracion;
                    break;
                case 'monto_fijo':
                    $totalAPagar = $precioBaseTotal - $promo->valor_descuento;
                    $precioCongelado = $totalAPagar / $mesesDuracion;
                    break;
                case 'meses_gratis':
                    $mesesPagados = $mesesDuracion - $promo->valor_descuento;
                    $totalAPagar = $precioCongelado * $mesesPagados;
                    break;
            }
        } else {
            $mesesDuracion = $request->meses_a_pagar;
            $totalAPagar = $precioCongelado * $mesesDuracion;
        }

        // 3. Guardamos todo en la base de datos dentro de una transacción
        try {
            DB::transaction(function () use ($request, $contract, $totalAPagar, $mesesDuracion, $precioCongelado) {
                // Creamos el registro del Pago
                $payment = Payment::create([
                    'factura_id' => null, // Es un pago adelantado, no ligado a una factura
                    'fecha_pago' => Carbon::now(),
                    'monto_pagado' => $totalAPagar,
                    'metodo_pago' => 'Adelantado/Promo', // O un método que elijas
                    'notas' => 'Pago adelantado por ' . $mesesDuracion . ' meses.',
                ]);

                // Creamos el registro del Período Prepagado
                PrepaidPeriod::create([
                    'contract_id' => $contract->id,
                    'payment_id' => $payment->id,
                    'fecha_inicio' => Carbon::now()->startOfDay(),
                    'fecha_fin' => Carbon::now()->addMonths($mesesDuracion)->endOfDay(),
                    'precio_congelado_mensual' => $precioCongelado,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al procesar el pago: ' . $e->getMessage());
        }

        return redirect()->route('billing.index', ['client_id' => $request->client_id])
            ->with('success', '¡Pago adelantado por ' . $mesesDuracion . ' meses registrado exitosamente!');
    }
}
