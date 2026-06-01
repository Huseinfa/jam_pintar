<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // public function show()
    // {
    //     $user = auth()->user();
    //     return view('pages.student.profile', compact('user'));
    // }
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->load('city');

        $latestAttempt = $user->testAttempts()
            ->with('result.recommendation')
            ->latest()
            ->first();

        $result = $latestAttempt?->result;

        // Ambil pending feedbacks - feedback yang belum disubmit
        $pendingFeedbacks = $user->feedbackInvitations()
            ->where('email_sent_at', '!=', null)
            ->get()
            ->filter(function ($invitation) {
                return !$invitation->isFeedbackSubmitted();
            })
            ->count();

        return view('pages.student.profile', compact(
            'user',
            'result',
            'pendingFeedbacks'
        ));
    }
}
