<?php

namespace App\Console\Commands;

use App\Jobs\SendResultEmail;
use App\Models\Result;
use Illuminate\Console\Command;

class RetrySendResultEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'result:retry-emails {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry sending result emails that failed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('all')) {
            // Retry semua yang belum terkirim (pending dan failed)
            $results = Result::whereNull('email_sent_at')->get();
            $this->info("Retrying {$results->count()} pending emails...");
        } else {
            // Hanya retry yang failed
            $results = Result::where('email_status', 'failed')->get();
            $this->info("Retrying {$results->count()} failed emails...");
        }

        foreach ($results as $result) {
            SendResultEmail::dispatch($result);
            $this->line("✓ Queued result #{$result->id} for {$result->testAttempt->user->name}");
        }

        $this->info('Done!');
    }
}
