<?php

namespace App\Console\Commands;

use App\Jobs\SendFeedbackReminderEmail;
use App\Models\FeedbackInvitation;
use Illuminate\Console\Command;

class SendFeedbackReminders extends Command
{
    protected $signature = 'feedback:send-reminders';

    protected $description = 'Send feedback reminders to users who haven\'t submitted feedback';

    public function handle()
    {
        // Cari feedback invitations yang:
        // 1. Email sudah dikirim lebih dari 7 hari lalu
        // 2. Belum ada reminder yang dikirim
        // 3. Feedback belum disubmit
        
        $sevenDaysAgo = now()->subDays(7)->endOfDay();
        
        $invitations = FeedbackInvitation::where('email_sent_at', '<', $sevenDaysAgo)
            ->whereNull('reminder_sent_at')
            ->where('feedback_submitted', false)
            ->get();

        $count = $invitations->count();
        
        if ($count === 0) {
            $this->info('No feedback reminders to send.');
            return;
        }

        foreach ($invitations as $invitation) {
            SendFeedbackReminderEmail::dispatch($invitation);
        }

        $this->info("Dispatched feedback reminders for {$count} users.");
    }
}
