<?php

namespace App\Jobs;

use App\Mail\FeedbackReminderMail;
use App\Models\FeedbackInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeedbackReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private FeedbackInvitation $invitation)
    {
    }

    public function handle(): void
    {
        // Cek apakah sudah ada reminder yang dikirim
        if ($this->invitation->reminder_sent_at !== null) {
            return;
        }

        // Cek apakah user mengizinkan email
        if (!$this->invitation->user->allow_feedback_emails) {
            return;
        }

        // Cek apakah feedback sudah diisi
        if ($this->invitation->isFeedbackSubmitted()) {
            return;
        }

        // Kirim email reminder
        Mail::to($this->invitation->user->email)
            ->send(new FeedbackReminderMail($this->invitation));

        // Update reminder_sent_at
        $this->invitation->update(['reminder_sent_at' => now()]);
    }
}
