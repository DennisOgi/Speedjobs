<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    public function index()
    {
        $workshops = Workshop::active()->upcoming()->ordered()->paginate(12);
        return view('workshops.index', compact('workshops'));
    }

    public function show(Workshop $workshop)
    {
        $isRegistered = false;
        $registration = null;
        
        if (Auth::check()) {
            $registration = Auth::user()->workshopRegistrations()
                ->where('workshop_id', $workshop->id)
                ->first();
            $isRegistered = $registration !== null;
        }

        return view('workshops.show', compact('workshop', 'isRegistered', 'registration'));
    }

    public function register(Request $request, Workshop $workshop)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Please login to register for this workshop.');
        }

        $user = Auth::user();

        // Check if already registered
        if ($user->hasRegisteredForWorkshop($workshop)) {
            return back()->with('error', 'You have already registered for this workshop.');
        }

        // Check if workshop is sold out
        if ($workshop->is_sold_out) {
            return back()->with('error', 'Sorry, this workshop is fully booked.');
        }

        // Validate optional reason
        $validated = $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        // Create registration
        WorkshopRegistration::create([
            'user_id' => $user->id,
            'workshop_id' => $workshop->id,
            'status' => 'pending',
            'notes' => $validated['reason'] ?? null,
        ]);

        return back()->with('success', 'You have successfully registered for this workshop! Your registration is pending approval.');
    }

    public function cancelRegistration(Workshop $workshop)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $registration = Auth::user()->workshopRegistrations()
            ->where('workshop_id', $workshop->id)
            ->first();

        if ($registration) {
            $registration->cancel();
            return back()->with('success', 'Your registration has been cancelled.');
        }

        return back()->with('error', 'Registration not found.');
    }
}
