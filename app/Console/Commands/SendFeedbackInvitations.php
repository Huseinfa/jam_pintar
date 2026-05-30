<?php

namespace App\Console\Commands;

use App\Jobs\SendFeedbackInvitationEmail;
use App\Models\TestAttempt;
use Illuminate\Console\Command;

class SendFeedbackInvitations extends Command
{
    protected $signature = 'feedback:send-invitations {--days=7 : Jumlah hari setelah test sebelum mengirim invitation}';

    protected $description = 'Send feedback invitations to users after their test attempt';

    public function handle()
    {
        // Ambil jumlah hari dari option (default 7)
        $days = (int) $this->option('days');
        $this->info("Sending feedback invitations for test attempts completed {$days} day(s) ago or more...");
        
        // Cari test attempts yang sudah selesai N hari yang lalu
        $daysAgo = now()->subDays($days)->startOfDay();
        
        $testAttempts = TestAttempt::where('finished_at', '<', $daysAgo)
            ->whereDoesntHave('feedbackInvitations')
            ->whereHas('user', function ($query) {
                $query->where('role', 'user');
            })
            ->with('user')
            ->get();

        $count = $testAttempts->count();
        
        if ($count === 0) {
            $this->info('No test attempts to send feedback invitations for.');
            return;
        }

        $sent = 0;
        $skipped = 0;

        foreach ($testAttempts as $attempt) {
            // Skip users tanpa email atau tanpa izin feedback
            if (!$attempt->user->email || !$attempt->user->allow_feedback_emails) {
                $this->warn("Skipped {$attempt->user->name} - no email or not allowed");
                $skipped++;
                continue;
            }

            try {
                SendFeedbackInvitationEmail::dispatch($attempt);
                $this->line("✓ Dispatched feedback invitation for {$attempt->user->name}");
                $sent++;
            } catch (\Exception $e) {
                $this->error("Failed for {$attempt->user->name}: " . $e->getMessage());
                $skipped++;
            }
        }

        $this->info("Sent: {$sent}, Skipped: {$skipped}");
    }
}
