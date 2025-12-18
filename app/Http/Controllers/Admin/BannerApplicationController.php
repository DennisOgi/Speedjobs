<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerApplication;
use Illuminate\Http\Request;

class BannerApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = BannerApplication::with(['banner', 'user', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('banner_id')) {
            $query->where('banner_id', $request->banner_id);
        }

        $applications = $query->latest()->paginate(15);
        $banners = \App\Models\Banner::orderBy('title')->get();

        return view('admin.banner-applications.index', compact('applications', 'banners'));
    }

    public function show(BannerApplication $application)
    {
        $application->load(['banner', 'user', 'reviewer']);
        return view('admin.banner-applications.show', compact('application'));
    }

    public function approve(Request $request, BannerApplication $application)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $application->approve(auth()->id(), $request->admin_notes);

        return back()->with('success', 'Application approved successfully.');
    }

    public function reject(Request $request, BannerApplication $application)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $application->reject(auth()->id(), $request->admin_notes);

        return back()->with('success', 'Application rejected.');
    }
}
