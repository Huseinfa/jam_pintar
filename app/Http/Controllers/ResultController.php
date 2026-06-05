<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendResultEmail;
use App\Models\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


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

        $pdf = Pdf::loadView('pdf.result', compact('result'));
        $fileName = 'hasil-rekomendasi-' . $attemptId . '-' . now()->timestamp . '.pdf';
        $filePath = 'results/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        $result->update([
            'pdf_path' => $filePath,
            'email_status' => 'pending',
        ]);

        SendResultEmail::dispatch($result);

        return redirect()
            ->route('result.show', $attemptId)
            ->with('email_sent', true);
    }

    public function resendEmailFromProfile($attemptId)
    {
        $result = Result::with([
            'recommendation',
            'testAttempt.user'
        ])
            ->where('test_attempt_id', $attemptId)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.result', compact('result'));
        $fileName = 'hasil-rekomendasi-' . $attemptId . '-' . now()->timestamp . '.pdf';
        $filePath = 'results/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        $result->update([
            'pdf_path' => $filePath,
            'email_status' => 'pending',
        ]);

        SendResultEmail::dispatch($result);

        return redirect()
            ->route('student.profile')
            ->with('email_sent_profile', true);
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