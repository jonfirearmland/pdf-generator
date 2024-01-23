<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;


Route::get('/generate-pdf', [PdfController::class, 'generatePDF']);
Route::get('/generate-signed-pdf', [PdfController::class, 'generateSignedPDF'])->name('generate-signed-pdf');;

Route::get('/signature', function () {
    return view('signature_pad');
});


