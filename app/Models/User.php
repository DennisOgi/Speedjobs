<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_paid',
        'university',
        'field_of_study',
        'graduation_year',
        'skills',
        'experience_level',
        'phone',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_paid' => 'boolean',
        ];
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function counselingRequests()
    {
        return $this->hasMany(CounselingRequest::class);
    }

    public function counselorBookings()
    {
        return $this->hasMany(CounselorBooking::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    public function hasAppliedTo(Job $job): bool
    {
        return $this->jobApplications()->where('job_id', $job->id)->exists();
    }

    public function hasSaved(Job $job): bool
    {
        return $this->savedJobs()->where('job_id', $job->id)->exists();
    }

    public function workshopRegistrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    public function registeredWorkshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshop_registrations')
            ->withPivot('status', 'notes', 'approved_at')
            ->withTimestamps();
    }

    public function hasRegisteredForWorkshop(Workshop $workshop): bool
    {
        return $this->workshopRegistrations()->where('workshop_id', $workshop->id)->exists();
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class)->orderBy('updated_at', 'desc');
    }
}
