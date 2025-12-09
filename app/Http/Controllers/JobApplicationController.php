<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = auth()->user()->jobApplications()
            ->with('job')
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function store(Request $request, Job $job)
    {
        // Check if already applied
        if (auth()->user()->hasAppliedTo($job)) {
            return back()->with('error', 'You have already applied to this job.');
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        JobApplication::create([
            'user_id' => auth()->id(),
            'job_id' => $job->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your application has been submitted successfully!');
    }

    public function withdraw(JobApplication $application)
    {
        // Ensure user owns this application
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $application->update(['status' => 'withdrawn']);

        return back()->with('success', 'Your application has been withdrawn.');
    }
}
