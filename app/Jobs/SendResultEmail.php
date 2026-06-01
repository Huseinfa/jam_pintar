<?php

namespace App\Jobs;

use App\Mail\ResultMail;
use App\Models\Result;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendResultEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Result $result,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Pastikan user memiliki email
        if (!$this->result->testAttempt->user->email) {
            $this->result->update([
                'email_status' => 'failed',
                'email_sent_at' => now(),
            ]);
            return;
        }

        try {
            // Kirim email ke user
            Mail::to($this->result->testAttempt->user->email)
                ->send(new ResultMail($this->result));

            // Update status
            $this->result->update([
                'email_status' => 'sent',
                'email_sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log error dan set status failed
            \Illuminate\Support\Facades\Log::error('Failed to send result email', [
                'result_id' => $this->result->id,
                'error' => $e->getMessage(),
            ]);

            $this->result->update([
                'email_status' => 'failed',
                'email_sent_at' => now(),
            ]);
        }
    }
}
