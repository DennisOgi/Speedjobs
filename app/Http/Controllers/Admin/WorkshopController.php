<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkshopController extends Controller
{
    public function index()
    {
        $workshops = Workshop::withCount('registrations')->ordered()->paginate(15);
        return view('admin.workshops.index', compact('workshops'));
    }

    public function create()
    {
        return view('admin.workshops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'instructor' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date|after:now',
            'end_date' => 'nullable|date|after:start_date',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'max_participants' => 'nullable|integer|min:1',
            'registration_link' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('workshops', 'public');
        }

        $validated['is_free'] = $request->boolean('is_free');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Workshop::create($validated);

        return redirect()->route('admin.workshops.index')
            ->with('success', 'Workshop created successfully.');
    }

    public function edit(Workshop $workshop)
    {
        return view('admin.workshops.edit', compact('workshop'));
    }

    public function update(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'instructor' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'max_participants' => 'nullable|integer|min:1',
            'registration_link' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($workshop->banner_image && Storage::disk('public')->exists($workshop->banner_image)) {
                Storage::disk('public')->delete($workshop->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('workshops', 'public');
        }

        $validated['is_free'] = $request->boolean('is_free');
        $validated['is_active'] = $request->boolean('is_active');

        $workshop->update($validated);

        return redirect()->route('admin.workshops.index')
            ->with('success', 'Workshop updated successfully.');
    }

    public function destroy(Workshop $workshop)
    {
        // Delete banner image
        if ($workshop->banner_image && Storage::disk('public')->exists($workshop->banner_image)) {
            Storage::disk('public')->delete($workshop->banner_image);
        }

        $workshop->delete();

        return redirect()->route('admin.workshops.index')
            ->with('success', 'Workshop deleted successfully.');
    }

    // Registration Management
    public function registrations()
    {
        $registrations = WorkshopRegistration::with(['user', 'workshop'])
            ->latest()
            ->paginate(20);
        
        return view('admin.workshops.registrations', compact('registrations'));
    }

    public function workshopRegistrations(Workshop $workshop)
    {
        $registrations = $workshop->registrations()
            ->with('user')
            ->latest()
            ->paginate(20);
        
        return view('admin.workshops.workshop-registrations', compact('workshop', 'registrations'));
    }

    public function approveRegistration(WorkshopRegistration $registration)
    {
        $registration->approve();
        return back()->with('success', 'Registration approved successfully.');
    }

    public function rejectRegistration(WorkshopRegistration $registration)
    {
        $registration->reject();
        return back()->with('success', 'Registration rejected.');
    }
}
