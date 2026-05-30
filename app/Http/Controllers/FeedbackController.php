<?php

namespace App\Http\Controllers;

use App\Models\FeedbackInvitation;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FeedbackController extends Controller
{
    public function showForm($token): View
    {
        $invitation = FeedbackInvitation::where('token', $token)
            ->firstOrFail();

        // Cek apakah feedback sudah diisi
        if ($invitation->isFeedbackSubmitted()) {
            abort(403, 'Feedback sudah pernah diisi sebelumnya.');
        }

        // Ambil questions dengan type 'feedback'
        $feedbackQuestions = Question::where('question_type', 'feedback')->get();

        // Restore form data dari session jika ada (setelah login dari form submit attempt)
        $savedFormInput = session()->get('saved_form_input', []);
        session()->forget('saved_form_input');

        return view('feedback.form', [
            'invitation' => $invitation,
            'user' => $invitation->user,
            'questions' => $feedbackQuestions,
            'savedInput' => $savedFormInput,
        ]);
    }

    public function submitFeedback(Request $request, $token): RedirectResponse
    {
        $invitation = FeedbackInvitation::where('token', $token)
            ->firstOrFail();

        // Cek apakah feedback sudah diisi
        if ($invitation->isFeedbackSubmitted()) {
            return redirect()->route('dashboard')->with('error', 'Feedback sudah pernah diisi sebelumnya.');
        }

        // Ambil questions dengan type 'feedback'
        $feedbackQuestions = Question::where('question_type', 'feedback')->get();

        // Validasi dinamis berdasarkan questions yang ada
        $validationRules = [];
        foreach ($feedbackQuestions as $question) {
            $validationRules["answer.{$question->id}"] = 'required|string|min:10|max:2000';
        }

        $validated = $request->validate($validationRules);

        // Save jawaban ke tabel answers
        foreach ($feedbackQuestions as $question) {
            $answerText = $request->input("answer.{$question->id}");

            // Delete jawaban lama jika ada
            Answer::where('question_id', $question->id)
                ->where('test_attempt_id', $invitation->test_attempt_id)
                ->delete();

            // Create jawaban baru
            Answer::create([
                'question_id' => $question->id,
                'test_attempt_id' => $invitation->test_attempt_id,
                'answer' => $answerText,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Terima kasih atas feedback Anda!');
    }

    public function listPendingReminders(): View
    {
        $user = auth()->user();

        // Ambil feedback invitations yang belum diisi
        $pendingFeedbacks = $user->feedbackInvitations()
            ->where('email_sent_at', '!=', null)
            ->orderBy('email_sent_at', 'desc')
            ->get()
            ->filter(function ($invitation) {
                return !$invitation->isFeedbackSubmitted();
            });

        return view('feedback.pending-reminders', [
            'pendingFeedbacks' => $pendingFeedbacks,
        ]);
    }
}
