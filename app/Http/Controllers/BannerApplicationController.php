<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerApplicationController extends Controller
{
    public function apply(Request $request, Banner $banner)
    {
        $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Check if user already applied
        $existingApplication = BannerApplication::where('banner_id', $banner->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied to this programme.');
        }

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        BannerApplication::create([
            'banner_id' => $banner->id,
            'user_id' => auth()->id(),
            'cover_letter' => $request->cover_letter,
            'resume_path' => $resumePath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your application has been submitted successfully!');
    }

    public function myApplications()
    {
        $applications = BannerApplication::with('banner')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('banner-applications.index', compact('applications'));
    }
}
