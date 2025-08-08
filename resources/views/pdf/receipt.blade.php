<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Recibo #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10pt;
            color: #333;
        }

        .receipt-container {
            width: 100%;
        }

        .header,
        .details-section {
            margin-bottom: 20px;
        }

        .company-details {
            text-align: right;
        }

        .company-name {
            font-size: 1.6em;
            font-weight: 600;
            color: #007bff;
            margin: 0;
        }

        .client-info h2 {
            font-size: 0.9em;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .receipt-info {
            text-align: right;
            font-size: 0.9em;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background-color: #f2f8ff;
            color: #007bff;
            font-weight: 600;
            text-align: left;
            padding: 8px;
            border-bottom: 2px solid #dee2e6;
        }

        .items-table td {
            padding: 8px;
            border-bottom: 1px solid #f0f0f0;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table tfoot .total-row td {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 1.1em;
            color: #000;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 9pt;
            color: #333;
        }

        table {
            width: 100%;
        }

        .w-50 {
            width: 50%;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <table>
            <tr>
                <td class="w-50">
                    <h1 class="company-name">UPCore ISP</h1>
                </td>
                <td class="w-50 text-right">
                    <p>Recibo #: <strong>{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
                    <p>Fecha de Pago:
                        <strong>{{ \Carbon\Carbon::parse($payment->fecha_pago)->format('d/m/Y') }}</strong></p>
                </td>
            </tr>
        </table>

        <hr style="margin: 20px 0;">

        <table>
            <tr>
                <td class="w-50">
                    <h2>Cliente</h2>
                    <p><strong>{{ $invoice->contract->client->nombre }}
                            {{ $invoice->contract->client->apellido }}</strong></p>
                    <p>DNI/CUIT: {{ $invoice->contract->client->dni_cuit }}</p>
                    <p>{{ $invoice->contract->serviceAddress->direccion }},
                        {{ $invoice->contract->serviceAddress->ciudad }}</p>
                </td>
            </tr>
        </table>

        <br><br>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Servicio de Internet - Plan {{ $invoice->contract->plan->nombre_plan }} - Período
                        {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('m/Y') }}</td>
                    <td class="text-right">${{ number_format($invoice->monto, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>Método de Pago: {{ $payment->metodo_pago }}</td>
                    <td class="text-right"><strong>TOTAL PAGADO:
                            ${{ number_format($payment->monto_pagado, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <footer class="footer">
            <p><strong>Gracias por su pago.</strong></p>
        </footer>
    </div>
</body>

</html>
