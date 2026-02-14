<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiSession extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'module',
        'status',
        'current_step',
        'total_steps',
        'context_data',
        'report_data',
    ];

    protected $casts = [
        'context_data' => 'array',
        'report_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(AiSessionStep::class, 'session_id')->orderBy('step_number');
    }

    public function latestStep()
    {
        return $this->hasMany(AiSessionStep::class, 'session_id')
            ->orderByDesc('step_number')
            ->first();
    }

    public function isComplete(): bool
    {
        return $this->status === 'completed';
    }

    public function getProgressPercentage(): int
    {
        if ($this->total_steps === 0) return 0;
        return (int) round(($this->current_step / $this->total_steps) * 100);
    }
}
