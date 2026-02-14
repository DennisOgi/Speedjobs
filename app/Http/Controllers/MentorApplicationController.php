<?php

namespace App\Http\Controllers;

use App\Models\MentorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorApplicationController extends Controller
{
    /**
     * Show the application form
     */
    public function create()
    {
        $user = Auth::user();
        
        // Check if user already has an application
        $existingApplication = $user->mentorApplications()->latest()->first();
        
        return view('mentorship.apply', compact('existingApplication'));
    }

    /**
     * Store a new mentor application
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if user already has a pending or approved application
        $existingApplication = $user->mentorApplications()
            ->whereIn('status', ['pending', 'approved'])
            ->first();
            
        if ($existingApplication) {
            return back()->with('error', 'You already have an active mentor application.');
        }

        $validated = $request->validate([
            'expertise_area' => 'required|string|max:255',
            'bio' => 'required|string|min:100',
            'years_experience' => 'required|integer|min:1|max:50',
            'industry' => 'required|string|max:255',
            'mentoring_approach' => 'required|string|min:50',
            'availability' => 'required|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $application = $user->mentorApplications()->create($validated);

        return redirect()->route('mentorship.my-application')
            ->with('success', 'Your mentor application has been submitted successfully! We will review it and get back to you soon.');
    }

    /**
     * Show user's application status
     */
    public function myApplication()
    {
        $user = Auth::user();
        $application = $user->mentorApplications()->latest()->first();

        return view('mentorship.my-application', compact('application'));
    }
}
