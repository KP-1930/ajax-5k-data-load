<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Tcpdf\Fpdi;




class PdfController extends Controller
{
    public function fillPdf(Request $request)
{
    $name = $request->input('name');
    $email = $request->input('email');

    // Path to your existing PDF file
    $path = storage_path('app/public/file-sample_150kB.pdf');

    // Create an instance of FPDI (which extends TCPDF)
    $pdf = new Fpdi();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Editable PDF');
    $pdf->SetSubject('FPDI and TCPDF Example');

    // Add a page
    $pdf->AddPage();

    // Set the source file (existing PDF)
    $pdf->setSourceFile($path);

    // Import the first page of the PDF
    $template = $pdf->importPage(1);

    // Use the imported page as the template
    $pdf->useTemplate($template);

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add editable form fields
    $pdf->SetXY(50, 100); // Adjust position
    $pdf->TextField('name', 50, 10, ['value' => $name]);

    $pdf->SetXY(50, 120); // Adjust position
    $pdf->TextField('email', 50, 10, ['value' => $email]);

    // Output the PDF inline in the browser
    return response($pdf->Output('filled_pdf.pdf', 'I')) // 'I' for inline display
        ->header('Content-Type', 'application/pdf');
}
}
