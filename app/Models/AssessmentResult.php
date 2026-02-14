<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentResult extends Model
{
    protected $fillable = [
        'user_id',
        'assessment_type',
        'questions_data',
        'answers_data',
        'ai_analysis',
        'scores',
        'recommendations',
        'completed_at',
    ];

    protected $casts = [
        'questions_data' => 'array',
        'answers_data' => 'array',
        'scores' => 'array',
        'recommendations' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('assessment_type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('completed_at', 'desc');
    }

    public function getOverallScoreAttribute(): ?float
    {
        if (!$this->scores) {
            return null;
        }

        $scores = array_values($this->scores);
        return count($scores) > 0 ? array_sum($scores) / count($scores) : null;
    }
}
