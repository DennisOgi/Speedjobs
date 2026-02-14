<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewSession extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'experience_level',
        'questions_data',
        'answers_data',
        'evaluations_data',
        'scores',
        'questions_count',
        'average_score',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'questions_data' => 'array',
        'answers_data' => 'array',
        'evaluations_data' => 'array',
        'scores' => 'array',
        'questions_count' => 'integer',
        'average_score' => 'float',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentageAttribute(): int
    {
        if ($this->questions_count === 0) return 0;
        
        $answeredCount = count($this->answers_data ?? []);
        return round(($answeredCount / $this->questions_count) * 100);
    }

    public function getScoreColorAttribute(): string
    {
        if ($this->average_score >= 80) return 'green';
        if ($this->average_score >= 60) return 'yellow';
        return 'red';
    }
}
