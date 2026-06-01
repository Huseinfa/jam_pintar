<?php

namespace App\Http\Controllers;

use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\View\View;
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
        $feedbackAnswers = $testAttempt->answers()
            ->with('question')
            ->whereHas('question', function ($q) {
                $q->where(
                    'question_type',
                    'feedback'
                );
            })
            ->get();

        $user = $testAttempt->user;
        $answers = $feedbackAnswers;
        $testDate = $testAttempt->created_at;
        $feedbackDate = $testAttempt->updated_at;
        $jamPintar = null;
        $kategori = null;

        return view(
            'pages.backoffice.feedback_result.show',
            [
                'user' => $user,
                'answers' => $answers,
                'testDate' => $testDate,
                'feedbackDate' => $feedbackDate,
                'jamPintar' => $jamPintar,
                'kategori' => $kategori,
            ]
        );
    }
}
