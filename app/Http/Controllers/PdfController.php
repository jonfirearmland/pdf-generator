<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use TCPDF;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to Laravel PDF',
            'date' => date('m/d/Y')
        ];
        
        $pdf = PDF::loadView('myPDF', $data);

        return $pdf->download('laravel-pdf.pdf');
    }

    public function generateSignedPDF(Request $request)
    {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Jon Aguilar');
        $pdf->SetTitle('TCPDF Example');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // Add a page
        $pdf->AddPage();

        // Set content
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0, 'Hello, this is a digitally signed PDF!');

         // Set certificate file path using the absolute path
       // Set the certificate and private key
    $certificate = 'file://' . base_path('mycertificate.crt');
    $private_key = 'file://' . base_path('myprivatekey.key');

        // Set additional information
        $info = array(
            'Name' => 'Jon Aguilar',
            'Location' => 'Staples center',
            'Reason' => 'Testing TCPDF Sign',
            'ContactInfo' => 'http://www.example.com',
        );

        $image_parts = explode(";base64,", $request->signed);
        $image_base64 = base64_decode($image_parts[1]);

        $pdf->Image('@' . $image_base64, 10, 30, 90);

        // Sign the PDF
        $pdf->setSignature($certificate, $private_key, 'tcpdfdemo', '', 2, $info);

        // Output the PDF
        $pdf->Output('signed_pdf.pdf', 'D');
    }
}

