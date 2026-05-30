<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;


class OnboardingController extends Controller
{
    public function index()
    {
        // Ambil pertanyaan pretest
        $questions = Question::where('question_type', 'pretest')->get();

        return view('pages.student.pretest', [
            'questions' => $questions,
            'totalQuestions' => $questions->count(), // ← TAMBAHKAN INI
        ]);
    }

    public function submit(Request $request)
    {
        session([
            'pretest_answers' => $request->answers,
            'pretest_done' => true,
        ]);
        // return response()->json([
        //     'success' => true,
        // ]);
        // kondisi pengecekan apakah user sudah login atau belum, jika belum login, arahkan ke halaman login, jika sudah login arahkan ke halaman instruction

        if (Auth::check()) {
        return response()->json([
            'success' => true,
            'redirect' => route('student.index'),
        ]);
    }

        return response()->json([
            'success' => true,
            'redirect' => route('login'),
        ]);

    }
}
