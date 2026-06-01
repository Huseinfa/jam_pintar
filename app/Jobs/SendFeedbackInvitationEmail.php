<?php

namespace App\Jobs;

use App\Models\TestAttempt;
use App\Mail\FeedbackInvitationMail;
use App\Models\FeedbackInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendFeedbackInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private TestAttempt $testAttempt)
    {
    }

    public function handle(): void
    {
        // Load user relationship
        $this->testAttempt->load('user');

        // Cek apakah user mengizinkan email feedback
        if (!$this->testAttempt->user || !$this->testAttempt->user->allow_feedback_emails) {
            return;
        }

        // Cek apakah email valid
        if (!$this->testAttempt->user->email) {
            return;
        }

        // Cek apakah sudah ada invitation untuk test attempt ini
        $existingInvitation = FeedbackInvitation::where('test_attempt_id', $this->testAttempt->id)->first();
        if ($existingInvitation) {
            return;
        }

        // Buat invitation baru dengan token unik
        $invitation = FeedbackInvitation::firstOrCreate(
            ['test_attempt_id' => $this->testAttempt->id],
            [
                'user_id' => $this->testAttempt->user_id,
                'token' => Str::random(64),
                'email_sent_at' => now(),
            ]
        );

        // Kirim email
        try {
            Mail::to($invitation->user->email)
                ->send(new FeedbackInvitationMail($invitation));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send feedback invitation', [
                'invitation_id' => $invitation->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
