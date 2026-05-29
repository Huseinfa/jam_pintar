<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Jobs\SendResultEmail;

class Result extends Model
{
    protected $fillable = [
        'test_attempt_id',
        'recommendation_id',
        'pdf_path',
        'email_sent_at',
        'email_status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Ketika result dibuat, dispatch job untuk kirim email
        static::created(function ($model) {
            SendResultEmail::dispatch($model);
        });
    }

    public function recommendation(): BelongsTo
    {
        return $this->belongsTo(Recommendation::class);
    }

    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class);
    }

}

