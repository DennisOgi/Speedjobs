<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeAnalysis extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'resume_text',
        'job_description',
        'ai_analysis',
        'ats_score',
        'analyzed_at',
    ];

    protected $casts = [
        'ats_score' => 'integer',
        'analyzed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getScoreColorAttribute(): string
    {
        if ($this->ats_score >= 80) return 'green';
        if ($this->ats_score >= 60) return 'yellow';
        return 'red';
    }

    public function getScoreLabelAttribute(): string
    {
        if ($this->ats_score >= 80) return 'Excellent';
        if ($this->ats_score >= 60) return 'Good';
        if ($this->ats_score >= 40) return 'Fair';
        return 'Needs Improvement';
    }
}
