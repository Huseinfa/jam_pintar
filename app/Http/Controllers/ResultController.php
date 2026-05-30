<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;
use Barryvdh\DomPDF\Facade\Pdf;
// import bagian untuk save pdf ke storeage
use Illuminate\Support\Facades\Storage;

class ResultController extends Controller
{
    public function downloadPdf($attemptId)
    {
        $result = Result::with([
            'recommendation',
            'testAttempt.user'
        ])
        ->where('test_attempt_id', $attemptId)
        ->firstOrFail();

        // $pdf = Pdf::loadView('pdf.result', compact('result')); //coba untuk save ke dalam laravel
        // return $pdf->download('hasil-rekomendasi.pdf');
        // kedepannya coba untuk melakukan konfigurasi agar data rekomendasi tersimpan dan juga dapat dilakukan resend data
        // Generate PDF
        $pdf = Pdf::loadView('pdf.result', compact('result'));
        // nama file pdf yang akan disimpan
        $fileName = 'hasil-rekomendasi-' . $attemptId . '.pdf';

        // Path penyimpanan
        $filePath = 'results/' . $fileName;

        // Simpan PDF ke storage/app/public/results
        Storage::disk('public')->put(
            $filePath,
            $pdf->output()
        );

        // Simpan path PDF ke database
        $result->update([
            'pdf_path' => $filePath
        ]);

        // Download PDF
        return $pdf->download($fileName);
    }
}