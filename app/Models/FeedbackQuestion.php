<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackQuestion extends Model
{
    protected $fillable = [
        'question_text',
        'answer_type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}