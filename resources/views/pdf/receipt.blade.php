<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Recibo #{{ $invoice->id }}</title>
    <style>
        /* Pegamos tu style.css aquí, con pequeños ajustes */
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10pt;
            color: #333;
        }

        .receipt-container {
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company-logo .logo {
            max-width: 120px;
            height: auto;
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

        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .client-info h2 {
            font-size: 0.9em;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
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
    </style>
</head>

<body>
    <div class="receipt-container">
        <header class="header">
            <div class="company-details" style="width: 100%; text-align: center;">
                <p class="company-name">UPCore</p>
                <p>Dirección: Tu Dirección, Tu Ciudad</p>
                <p><strong>CUIT: XX-XXXXXXXX-X</strong></p>
                <p>contacto@upcore.com | (XXX) XXX-XXXX</p>
            </div>
        </header>

        <section class="details-section">
            <div class="client-info">
                <h2>CLIENTE</h2>
                <p><strong>Nombre:</strong> {{ $invoice->contract->client->nombre }}
                    {{ $invoice->contract->client->apellido }}</p>
                <p><strong>DNI/CUIT:</strong> {{ $invoice->contract->client->dni_cuit }}</p>
                <p><strong>Domicilio:</strong> {{ $invoice->contract->serviceAddress->direccion }},
                    {{ $invoice->contract->serviceAddress->ciudad }}</p>
            </div>
            <div class="receipt-info">
                <p><strong>RECIBO N°:</strong> {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>FECHA DE PAGO:</strong> {{ \Carbon\Carbon::parse($payment->fecha_pago)->format('d/m/Y') }}
                </p>
            </div>
        </section>

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
                    <td>MÉTODO DE PAGO: {{ $payment->metodo_pago }}</td>
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
