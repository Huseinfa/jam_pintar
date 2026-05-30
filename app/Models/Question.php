<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'question_text',
        'question_type',
        'option',
        'answer_type',
    ];
 
    protected $casts = [
        'option' => 'array',
    ];
 
    //relation
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    //helper
    public function isKuisioner(): bool
    {
        return $this->question_type === 'kuisioner';
    }
    public function isFeedback(): bool
    {
        return $this->question_type === 'feedback';
    }
    // public function isTest(): bool
    // {
    //     return $this->question_type === 'test';
    // }
 
    // public function isRating(): bool
    // {
    //     return $this->question_type === 'rating';
    // }
 
    public function isPreTest(): bool
    {
        return $this->question_type === 'pretest';
    }
 
    public function isChoice(): bool
    {
        return $this->answer_type === 'choice';
    }
 
    public function isEssay(): bool
    {
        return $this->answer_type === 'essay';
    }
}