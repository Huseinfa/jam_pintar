<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackInvitation extends Model
{
    protected $fillable = [
        'user_id',
        'test_attempt_id',
        'token',
        'email_sent_at',
        'reminder_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'email_sent_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class);
    }

    /**
     * Check apakah feedback sudah disubmit
     * Dengan cara cek apakah ada answers untuk questions dengan type 'feedback'
     */
    public function isFeedbackSubmitted(): bool
    {
        return $this->testAttempt->answers()
            ->whereHas('question', function ($query) {
                $query->where('question_type', 'feedback');
            })
            ->exists();
    }

    public function isPending(): bool
    {
        return !$this->isFeedbackSubmitted();
    }

    public function isReminderNeeded(): bool
    {
        return !$this->isFeedbackSubmitted() && 
               $this->email_sent_at !== null && 
               now()->diffInDays($this->email_sent_at) >= 7;
    }
}
