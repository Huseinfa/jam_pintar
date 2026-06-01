<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackResult extends Model
{
    protected $fillable = [
        'feedback_question_id',
        'answer',
        'user_id', // optional kalau kamu pakai user login
    ];

    /*
    |-------------------------------------------------
    | RELASI: satu result milik satu pertanyaan
    |-------------------------------------------------
    */
    public function question()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'feedback_question_id');
    }

    /*
    |-------------------------------------------------
    | (OPTIONAL) RELASI USER
    |-------------------------------------------------
    | Kalau sistem kamu pakai login user
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}