<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Recibo de Pago</div>
        <div>Fecha: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <strong>Cliente</strong><br>
    {{ $client->nombre }}<br>
    @if ($client->email)
        {{ $client->email }}<br>
    @endif

    <table>
        <tr>
            <th># Factura</th>
            <td>{{ $invoice->id }}</td>
            <th>Estado</th>
            <td>{{ $invoice->estado }}</td>
        </tr>
        <tr>
            <th>Emisión</th>
            <td>{{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('d/m/Y') }}</td>
            <th>Vencimiento</th>
            <td>{{ \Carbon\Carbon::parse($invoice->fecha_vencimiento)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Contrato</th>
            <td>#{{ $invoice->contract->id }}</td>
            <th>Plan</th>
            <td>{{ $invoice->contract->plan->nombre ?? 'Plan' }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="right">Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Servicio {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('Y-m') }}</td>
                <td class="right">${{ number_format($invoice->monto, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th class="right">Total pagado</th>
                <th class="right">${{ number_format($invoice->monto, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    @if ($invoice->payments->count())
        <p><strong>Pagos</strong></p>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Método</th>
                    <th class="right">Monto</th>
                    <th>Notas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->payments as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->fecha_pago)->format('d/m/Y') }}</td>
                        <td>{{ $p->metodo_pago }}</td>
                        <td class="right">${{ number_format($p->monto_pagado, 2) }}</td>
                        <td>{{ $p->notas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p style="margin-top: 12px;">Gracias por su pago.</p>
</body>

</html>
