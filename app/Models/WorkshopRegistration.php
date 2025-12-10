<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkshopRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workshop_id',
        'status',
        'notes',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }
}
