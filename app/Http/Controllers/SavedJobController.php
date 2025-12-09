<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    public function index()
    {
        $savedJobs = auth()->user()->savedJobs()
            ->with('job')
            ->latest()
            ->paginate(10);

        return view('saved-jobs.index', compact('savedJobs'));
    }

    public function store(Job $job)
    {
        // Check if already saved
        if (auth()->user()->hasSaved($job)) {
            return back()->with('info', 'Job already saved.');
        }

        SavedJob::create([
            'user_id' => auth()->id(),
            'job_id' => $job->id,
        ]);

        return back()->with('success', 'Job saved successfully!');
    }

    public function destroy(Job $job)
    {
        auth()->user()->savedJobs()->where('job_id', $job->id)->delete();

        return back()->with('success', 'Job removed from saved list.');
    }
}
