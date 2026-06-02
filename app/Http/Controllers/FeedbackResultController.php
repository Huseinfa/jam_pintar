<?php

namespace App\Http\Controllers;

use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Exports\FeedbackExport;
use Maatwebsite\Excel\Facades\Excel;

use Symfony\Component\HttpFoundation\StreamedResponse;

class FeedbackResultController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 10;

        $query = TestAttempt::with([
            'user',
            'result.recommendation',
            'answers.question'
        ])
            ->whereHas('answers.question', function ($q) {
                $q->where('question_type', 'feedback');
            });

        if ($search) {

            $query->whereHas('user', function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                );
            });
        }

        $feedbacks =
            $perPage == 'all'
            ? $query->latest()->get()
            : $query->latest()->paginate($perPage);

        return view(
            'pages.backoffice.feedback_result.index',
            compact(
                'feedbacks',
                'search',
                'perPage'
            )
        );
    }

    public function show(TestAttempt $testAttempt): View
    {
        $testAttempt->load([
            'answers.question',
            'result.recommendation'
        ]);

        $feedbackAnswers = $testAttempt->answers
            ->filter(fn($a) => $a->question && $a->question->question_type === 'feedback');

        $user = $testAttempt->user;

        $testDate = $testAttempt->created_at;
        $feedbackDate = $testAttempt->updated_at;

        $rec = $testAttempt->result?->recommendation;

        $jamPintar = $rec
            ? \Carbon\Carbon::parse($rec->study_hour_start)->format('H:i') .
            ' - ' .
            \Carbon\Carbon::parse($rec->study_hour_end)->format('H:i')
            : '-';

        $kategori = $rec->prefered_study_time ?? '-';

        return view('pages.backoffice.feedback_result.show', [
            'user' => $user,
            'answers' => $feedbackAnswers,
            'testDate' => $testDate,
            'feedbackDate' => $feedbackDate,
            'jamPintar' => $jamPintar,
            'kategori' => $kategori,
        ]);
    }

    public function export()
    {
        return Excel::download(new FeedbackExport, 'feedback-result.xlsx');
    }
}
