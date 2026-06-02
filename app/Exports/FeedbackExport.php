<?php

namespace App\Exports;

use App\Models\TestAttempt;
use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeedbackExport implements FromCollection, WithHeadings
{
    private $questions;

    public function __construct()
    {
        // ambil semua pertanyaan feedback
        $this->questions = Question::where('question_type', 'feedback')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return array_merge(
            [
                'No',
                'Nama',
                'Email',
                'Tanggal Tes',
                'Tanggal Feedback',
                'Jam Pintar',
                'Kategori',
            ],
            $this->questions->map(fn($q) => $q->question_text)->toArray()
        );
    }

    public function collection()
    {
        return TestAttempt::with([
            'user',
            'result.recommendation',
            'answers.question'
        ])
            // 🔥 FILTER USER SAJA (BUKAN ADMIN)
            ->whereHas('user', function ($q) {
                $q->where('role', 'user');
                // kalau pakai is_admin:
                // $q->where('is_admin', 0);
            })
            ->get()
            ->values()
            ->map(function ($attempt, $index) {

                $user = $attempt->user;
                $recommendation = $attempt->result->recommendation ?? null;

                // mapping jawaban berdasarkan question_id
                $answers = $attempt->answers
                    ->filter(function ($a) {
                        return $a->question && $a->question->question_type === 'feedback';
                    })
                    ->keyBy('question_id');

                $row = [
                    $index + 1,
                    $user->name ?? '-',
                    $user->email ?? '-',
                    optional($attempt->created_at)->format('d M Y H:i:s'),
                    optional($attempt->updated_at)->format('d M Y H:i:s'),

                    $recommendation
                        ? ($recommendation->study_hour_start . ' - ' . $recommendation->study_hour_end)
                        : '-',

                    $recommendation->prefered_study_time ?? '-',
                ];

                // 🔥 pivot jawaban jadi kolom horizontal
                foreach ($this->questions as $q) {
                    $row[] = $answers[$q->id]->answer ?? '-';
                }

                return $row;
            });
    }
}
