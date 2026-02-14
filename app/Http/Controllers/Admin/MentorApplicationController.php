<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorApplicationController extends Controller
{
    /**
     * Display all mentor applications
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = MentorApplication::with('user')->latest();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $applications = $query->paginate(20);
        
        $stats = [
            'total' => MentorApplication::count(),
            'pending' => MentorApplication::pending()->count(),
            'approved' => MentorApplication::approved()->count(),
            'rejected' => MentorApplication::rejected()->count(),
        ];

        return view('admin.mentor-applications.index', compact('applications', 'stats', 'status'));
    }

    /**
     * Show a specific application
     */
    public function show(MentorApplication $application)
    {
        $application->load('user', 'reviewer');
        
        return view('admin.mentor-applications.show', compact('application'));
    }

    /**
     * Approve an application
     */
    public function approve(Request $request, MentorApplication $application)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $application->approve(Auth::id(), $request->admin_notes);

        return back()->with('success', 'Mentor application approved successfully!');
    }

    /**
     * Reject an application
     */
    public function reject(Request $request, MentorApplication $application)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $application->reject(Auth::id(), $request->admin_notes);

        return back()->with('success', 'Mentor application rejected.');
    }
}
