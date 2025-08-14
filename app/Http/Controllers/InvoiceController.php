<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Muestra/descarga el PDF desde storage/app/receipts usando response()->file()
     * (evita el warning de Intelephense).
     */
    public function showPdf(Invoice $invoice)
    {
        if (! $invoice->pdf_filename) {
            abort(404, 'El recibo no está disponible.');
        }

        $relativePath = 'receipts/' . $invoice->pdf_filename;
        $absolutePath = storage_path('app/' . $relativePath);

        if (! file_exists($absolutePath)) {
            abort(404, 'Archivo de recibo no encontrado.');
        }

        // Mostrar inline en el navegador (si el browser lo permite)
        return response()->file($absolutePath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $invoice->pdf_filename . '"',
        ]);
    }
}
