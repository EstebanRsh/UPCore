<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Contract;
use App\Models\Invoice;
use Carbon\Carbon;

class GenerateMonthlyInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // 1. Buscamos todos los contratos que estén activos
        $activeContracts = Contract::where('estado', 'Activo')->get();
        $billingPeriod = Carbon::now();

        foreach ($activeContracts as $contract) {
            // 2. Verificamos si el contrato está en un período prepagado
            $isPrepaid = $contract->prepaidPeriods()
                ->where('fecha_inicio', '<=', $billingPeriod)
                ->where('fecha_fin', '>=', $billingPeriod)
                ->exists();

            if ($isPrepaid) {
                continue; // Si está prepagado, saltamos al siguiente contrato
            }

            // 3. Verificamos si ya existe una factura para este contrato en el mes y año actual
            $alreadyInvoiced = $contract->invoices()
                ->whereYear('fecha_emision', $billingPeriod->year)
                ->whereMonth('fecha_emision', $billingPeriod->month)
                ->exists();

            if ($alreadyInvoiced) {
                continue; // Si ya se facturó, saltamos al siguiente
            }

            // 4. Si pasa todas las validaciones, creamos la factura
            Invoice::create([
                'contract_id' => $contract->id,
                'monto' => $contract->plan->precio_mensual,
                'fecha_emision' => $billingPeriod->today(),
                'fecha_vencimiento' => $billingPeriod->today()->addDays(10),
                'estado' => 'Pendiente',
            ]);
        }
    }
}
