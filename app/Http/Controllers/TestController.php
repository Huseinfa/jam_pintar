<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Recommendation;
use App\Models\Result;
use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TestController extends Controller
{
    public function index(): View
    {
        // Try to get questions with type 'test'
        $questions = Question::where('question_type', 'test')
            ->limit(10)
            ->get();

        // Fallback: if no 'test' type, get any questions
        if ($questions->isEmpty()) {
            $questions = Question::limit(10)->get();
        }

        // // pastikan admin tidak boleh mengikui tes dan hanya student saja
        // if(auth()->check() && auth()->user()->isAdmin()) {
        //     return redirect()->route('backoffice.index');
        // }

        return view('pages.student.test', [
            'questions' => $questions,
            'totalQuestions' => $questions->count(),
        ]);
    }

    public function submit(Request $request)
    {
        // VALIDASI
        $request->validate([
            'answers' => 'required|array',
        ]);

        // 1. SIMPAN TEST ATTEMPT
        $testAttempt = TestAttempt::create([
            // 'user_id' => Auth::id(),
            'user_id' => Auth::id(), 'started_at' => now(), 'finished_at' => now(),
        ]);

        // 2. SIMPAN JAWABAN
        foreach ($request->answers as $questionId => $answer) {

            Answer::create([
                'question_id' => $questionId,
                'test_attempt_id' => $testAttempt->id,
                'answer' => $answer,
            ]);
        }

        // 3. AMBIL REKOMENDASI SEMENTARA (DUMMY)
        // nanti diganti hasil python
        $recommendation = Recommendation::find(1);

        // 4. SIMPAN RESULT
        Result::create([
            'test_attempt_id' => $testAttempt->id,
            'recommendation_id' => $recommendation->id,
            'email_status' => 'pending',
        ]);

        // 5. RETURN RESPONSE
        return response()->json([
            'success' => true,
            'attempt_id' => $testAttempt->id,
        ]);
    }
}
