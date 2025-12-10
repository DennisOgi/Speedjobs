<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'banner_image',
        'instructor',
        'location',
        'start_date',
        'end_date',
        'price',
        'is_free',
        'max_participants',
        'registration_link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'workshop_registrations')
            ->withPivot('status', 'notes', 'approved_at')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('start_date');
    }

    public function getAvailableSpotsAttribute()
    {
        if (!$this->max_participants) {
            return null;
        }
        return $this->max_participants - $this->registrations()->whereIn('status', ['pending', 'approved'])->count();
    }

    public function getIsSoldOutAttribute()
    {
        if (!$this->max_participants) {
            return false;
        }
        return $this->available_spots <= 0;
    }

    public function getBannerUrlAttribute()
    {
        if (str_starts_with($this->banner_image, 'http')) {
            return $this->banner_image;
        }
        return asset('storage/' . $this->banner_image);
    }
}
