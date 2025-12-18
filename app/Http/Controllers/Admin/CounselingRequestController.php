<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use App\Models\Counselor;
use Illuminate\Http\Request;

class CounselingRequestController extends Controller
{
    public function index()
    {
        $requests = CounselingRequest::with(['user', 'assignedCounselor'])->latest()->paginate(15);
        return view('admin.counseling.index', compact('requests'));
    }

    public function show(CounselingRequest $counselingRequest)
    {
        $counselingRequest->load(['user', 'assignedCounselor']);
        $counselors = Counselor::with('user')->where('is_available', true)->get();
        
        return view('admin.counseling.show', compact('counselingRequest', 'counselors'));
    }

    public function assign(Request $request, CounselingRequest $counselingRequest)
    {
        $request->validate([
            'counselor_id' => 'required|exists:counselors,id',
            'admin_notes' => 'nullable|string',
        ]);

        $counselingRequest->update([
            'assigned_counselor_id' => $request->counselor_id,
            'status' => 'assigned',
            'admin_notes' => $request->admin_notes,
        ]);

        // TODO: Send notification to user about assignment

        return redirect()->route('admin.counseling.index')->with('success', 'Counselor assigned successfully.');
    }
}
