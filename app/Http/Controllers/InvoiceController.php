<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importante

class InvoiceController extends Controller
{
    /**
     * Muestra el PDF de una factura si existe en el almacenamiento.
     */
    public function showPdf(Invoice $invoice)
    {
        if (!$invoice->pdf_filename) {
            abort(404, 'La factura no tiene un archivo PDF asociado.');
        }

        $path = 'receipts/' . $invoice->pdf_filename;

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'El archivo PDF de la factura no fue encontrado en el servidor.');
        }

        // ¡ESTA ES LA CORRECCIÓN!
        return Storage::response($path);
    }
}
