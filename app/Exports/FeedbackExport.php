<?php

namespace App\Exports;

use App\Models\TestAttempt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeedbackExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Nama',
            'Jam Pintar',
            'Kategori',
            'Feedback Date',
            'Q1',
            'Q2',
            'Q3',
            'Q4',
            'Rata-rata',
            'Status',
        ];
    }

    public function collection()
    {
        return TestAttempt::with([
            'user',
            'result.recommendation',
            'answers.question'
        ])
        ->get()
        ->map(function ($attempt) {

            $feedbackAnswers =
                $attempt->answers
                ->filter(fn($a) =>
                    $a->question->question_type === 'feedback'
                )
                ->values();

            $scores =
                $feedbackAnswers
                ->pluck('answer')
                ->filter(fn($v) => is_numeric($v));

            $avg =
                $scores->count()
                ? round($scores->avg(), 1)
                : 0;

            $status =
                $avg >= 4
                ? 'Efektif'
                : ($avg >= 3
                    ? 'Cukup Efektif'
                    : 'Kurang Efektif');

            return [
                $attempt->user->name ?? '-',

                optional($attempt->result->recommendation)
                    ->study_hour_start
                . ' - ' .
                optional($attempt->result->recommendation)
                    ->study_hour_end,

                optional($attempt->result->recommendation)
                    ->prefered_study_time,

                optional($attempt->created_at)
                    ->format('d M Y'),

                $feedbackAnswers[0]->answer ?? '-',
                $feedbackAnswers[1]->answer ?? '-',
                $feedbackAnswers[2]->answer ?? '-',
                $feedbackAnswers[3]->answer ?? '-',

                $avg,

                $status,
            ];
        });
    }
}