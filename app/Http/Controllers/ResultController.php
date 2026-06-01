<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;
use Barryvdh\DomPDF\Facade\Pdf;
// import bagian untuk save pdf ke storeage
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class ResultController extends Controller
{
    // ─── Halaman hasil rekomendasi ─────────────────────────────────
    public function show($attemptId)
    {
        $result = Result::with([
            'recommendation',
            'testAttempt.user'
        ])
        ->where('test_attempt_id', $attemptId)
        ->firstOrFail();

        return view('pages.student.result', compact('result', 'attemptId'));
    }

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

    public function googleCalendar(Result $result)
    {
        // Logika untuk membuat event di Google Calendar berdasarkan hasil rekomendasi
        // Misalnya, Anda bisa menggunakan Google Calendar API untuk membuat event dengan detail dari $result
        // // Contoh sederhana: Redirect ke Google Calendar dengan pre-filled event (ini hanya contoh, Anda perlu menyesuaikan dengan kebutuhan)
        // $eventTitle = urlencode('Rekomendasi: ' . $result->recommendation->name);
        // $eventDetails = urlencode('Detail rekomendasi: ' . $result->recommendation->description);
        // $googleCalendarUrl = "https://www.google.com/calendar/render?action=TEMPLATE&text={$eventTitle}&details={$eventDetails}";
        // return redirect()->away($googleCalendarUrl);

        $recommendation = $result->recommendation;
        // tanggal hari ini
        $today = Carbon::today();
        // waktu mulai
        $start = Carbon::parse(
            $today->format('Y-m-d') . ' ' .
            $recommendation->study_hour_start
        );
        // waktu selesai
        $end = Carbon::parse(
            $today->format('Y-m-d') . ' ' .
            $recommendation->study_hour_end
        );
        // format Google Calendar
        $dates =
            $start->format('Ymd\THis') .
            '/' .
            $end->format('Ymd\THis');
        // title event
        $title = urlencode(
            'SmartPeak - Jadwal Belajar'
        );
        // deskripsi
        $details = urlencode(
            $recommendation->recomendation
        );
        // recurring harian
        $recurrence = urlencode(
            'RRULE:FREQ=DAILY'
        );
        // build URL
        $url = "https://calendar.google.com/calendar/render?action=TEMPLATE";
        $url .= "&text={$title}";
        $url .= "&dates={$dates}";
        $url .= "&details={$details}";
        $url .= "&recur={$recurrence}";
        return redirect($url);
        }
}