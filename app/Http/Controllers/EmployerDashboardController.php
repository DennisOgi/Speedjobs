<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class EmployerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Fetch jobs posted by the authenticated user
        $jobs = Job::where('user_id', $user->id)->latest()->get();
        
        // Get job IDs for this employer
        $jobIds = $jobs->pluck('id');
        
        // Fetch all applications for employer's jobs
        $applications = JobApplication::whereIn('job_id', $jobIds)
            ->with(['job', 'user'])
            ->latest()
            ->get();
        
        // Calculate stats
        $stats = [
            'active_jobs' => $jobs->count(),
            'total_applicants' => $applications->count(),
            'total_views' => $jobs->sum('views') ?? 0,
            'pending_applications' => $applications->where('status', 'pending')->count(),
        ];
        
        // Recent applications (last 5)
        $recentApplications = $applications->take(5);

        return view('employer.dashboard', compact('jobs', 'applications', 'recentApplications', 'stats'));
    }

    public function jobs()
    {
        $jobs = Job::where('user_id', auth()->id())
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function editJob(Job $job)
    {
        // Ensure employer owns this job
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        return view('employer.jobs.edit', compact('job'));
    }

    public function updateJob(Request $request, Job $job)
    {
        // Ensure employer owns this job
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string',
            'category' => 'required|string',
            'salary_range' => 'nullable|string',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
        ]);

        $job->update($validated);

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully!');
    }

    public function destroyJob(Job $job)
    {
        // Ensure employer owns this job
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully!');
    }

    public function applications(Job $job = null)
    {
        $user = auth()->user();
        $jobIds = Job::where('user_id', $user->id)->pluck('id');

        $query = JobApplication::whereIn('job_id', $jobIds)
            ->with(['job', 'user']);

        if ($job) {
            $query->where('job_id', $job->id);
        }

        $applications = $query->latest()->paginate(15);

        return view('employer.applications.index', compact('applications', 'job'));
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        // Ensure employer owns the job this application is for
        if ($application->job->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,interviewed,offered,rejected',
        ]);

        $application->update($validated);

        return back()->with('success', 'Application status updated!');
    }
}
