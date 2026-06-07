<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Recommendation;
use App\Models\Result;
use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TestController extends Controller
{
    public function index(): View
    {
        // Try to get questions with type 'test'
        $questions = Question::where('question_type', 'kuisioner')
            ->limit(10)
            ->get();

        // // pastikan admin tidak boleh mengikui tes dan hanya student saja
        // if(auth()->check() && auth()->user()->isAdmin()) {
        //     return redirect()->route('backoffice.index');
        // }

        return view('pages.student.test', [
        'questions'      => $questions,
        'totalQuestions' => $questions->count(),
    ]);
}

public function submit(Request $request)
{
    $request->validate([
        'answers' => 'required|array',
    ]);

    // 1. SIMPAN TEST ATTEMPT
    $testAttempt = TestAttempt::create([
        'user_id'     => Auth::id(),
        'started_at'  => now(),
        'finished_at' => now(),
    ]);

    // 2. SIMPAN JAWABAN
    foreach ($request->answers as $questionId => $answer) {
        Answer::create([
            'question_id'     => $questionId,
            'test_attempt_id' => $testAttempt->id,
            'answer'          => $answer,
        ]);
    }

    // 3. PETAKAN JAWABAN KE FITUR EDAS
        $answerMap = $request->answers;

        $features = [
            'study_hours_weekly'    => $answerMap[1] ?? null,  // Q1
            'organization_level'    => $answerMap[2] ?? null,  // Q2
            'procrastination_level' => $answerMap[3] ?? null,  // Q3
            'uses_study_aids'       => $answerMap[4] ?? null,  // Q4
            'study_location'        => $answerMap[5] ?? null,  // Q5
            'study_method'          => $answerMap[6] ?? null,  // Q6
        ];

    // 4. AMBIL DATA USER (github_username dari profile)
    $user = Auth::user();

    $payload = array_merge($features, [
        'github_username'  => $user->github_username ?? '',
        'usual_study_hour' => null,  // bisa ditambah nanti dari profile
    ]);

    // 5. PANGGIL FLASK API
    Log::info('Payload sent to Flask:', $payload);  // ← ADD THIS
    $recommendationSlot = $this->callFlaskApi($payload);

    // 6. CARI RECOMMENDATION BERDASARKAN SLOT
    Log::info('Flask returned slot: ' . $recommendationSlot);
    Log::info('Recommendations in DB: ', Recommendation::pluck('prefered_study_time')->toArray());

    $recommendation = Recommendation::where('prefered_study_time', $recommendationSlot)->first()
    ?? Recommendation::find(1);

    Log::info('Matched recommendation ID: ' . $recommendation->id . ' prefered_study_time: ' . $recommendation->prefered_study_time);

    // 7. SIMPAN RESULT (email akan dikirim saat user men-download PDF)
    $result = Result::create([
        'test_attempt_id'   => $testAttempt->id,
        'recommendation_id' => $recommendation->id,
        'email_status'      => 'pending',
    ]);

    return response()->json([
        'success'    => true,
        'attempt_id' => $testAttempt->id,
    ]);
}

// ─── Helper: panggil Flask ───────────────────────────────────────────────────

private function callFlaskApi(array $payload): string
{
    try {
        $flaskUrl = config('services.flask_api.url');

        $response = \Illuminate\Support\Facades\Http::timeout(10)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->asJson()  // ← ADD THIS
            ->post("{$flaskUrl}/recommend", $payload);

        if ($response->successful()) {
            $data = $response->json();
            return $data['recommendation'] ?? 'Morning';
        } else {
            Log::error('Flask API error: ' . $response->body());
            return 'Morning';
        }
    } catch (\Exception $e) {
        Log::error('Flask API exception: ' . $e->getMessage());
        return 'Morning';
    }
    }
}
