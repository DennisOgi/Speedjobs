<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerPathway extends Model
{
    protected $fillable = [
        'user_id',
        'current_role',
        'target_role',
        'pathway_data',
        'progress_percentage',
        'status',
        'ai_generated_at',
        'last_updated_at',
    ];

    protected $casts = [
        'pathway_data' => 'array',
        'ai_generated_at' => 'datetime',
        'last_updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function updateProgress(int $percentage): void
    {
        $this->update([
            'progress_percentage' => min(100, max(0, $percentage)),
            'last_updated_at' => now(),
        ]);

        if ($percentage >= 100) {
            $this->markAsCompleted();
        }
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function abandon(): void
    {
        $this->update(['status' => 'abandoned']);
    }

    public function getCompletedStepsAttribute(): int
    {
        if (!$this->pathway_data || !isset($this->pathway_data['steps'])) {
            return 0;
        }

        return collect($this->pathway_data['steps'])
            ->filter(fn($step) => $step['completed'] ?? false)
            ->count();
    }

    public function getTotalStepsAttribute(): int
    {
        return isset($this->pathway_data['steps']) ? count($this->pathway_data['steps']) : 0;
    }
}
