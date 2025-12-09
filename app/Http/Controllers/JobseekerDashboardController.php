<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobseekerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch personalized job recommendations based on user profile
        $query = \App\Models\Job::query();
        
        // Match by field of study or skills if available
        if ($user->field_of_study) {
            $query->where(function($q) use ($user) {
                $q->where('title', 'like', '%' . $user->field_of_study . '%')
                  ->orWhere('description', 'like', '%' . $user->field_of_study . '%');
            });
        }
        
        // Match by location if available
        if ($user->location) {
            $query->orWhere('location', 'like', '%' . $user->location . '%');
        }
        
        $recommendedJobs = $query->latest()->take(4)->get();
        
        // Fallback to latest jobs if no personalized matches
        if ($recommendedJobs->isEmpty()) {
            $recommendedJobs = \App\Models\Job::latest()->take(4)->get();
        }
        
        // Fetch active course enrollments
        $activeEnrollments = $user->courseEnrollments()
            ->with('course')
            ->latest()
            ->take(3)
            ->get();

        // Fetch recent counseling requests
        $counselingRequests = $user->counselingRequests()
            ->with('assignedCounselor.user')
            ->latest()
            ->take(3)
            ->get();

        // Fetch upcoming bookings
        $upcomingBookings = $user->counselorBookings()
            ->with('counselor.user')
            ->where('session_date', '>=', now())
            ->orderBy('session_date')
            ->orderBy('session_time')
            ->take(3)
            ->get();


        // Fetch recent job applications
        $recentApplications = $user->jobApplications()
            ->with('job')
            ->latest()
            ->take(5)
            ->get();

        // Fetch saved jobs
        $savedJobs = $user->savedJobs()
            ->with('job')
            ->latest()
            ->take(5)
            ->get(); 

        // Fetch resources
        $resources = \App\Models\Resource::where('is_active', true)->latest()->get();

        return view('dashboard', compact(
            'recommendedJobs', 
            'recentApplications', 
            'savedJobs',
            'activeEnrollments',
            'counselingRequests',
            'upcomingBookings',
            'resources'
        ));
    }
}
