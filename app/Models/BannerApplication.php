<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannerApplication extends Model
{
    protected $fillable = [
        'banner_id',
        'user_id',
        'status',
        'cover_letter',
        'resume_path',
        'admin_notes',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function approve($reviewerId, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
            'admin_notes' => $notes,
        ]);
    }

    public function reject($reviewerId, $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
            'admin_notes' => $notes,
        ]);
    }
}
