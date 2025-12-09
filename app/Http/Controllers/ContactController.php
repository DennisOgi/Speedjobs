<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:5000',
        ]);

        // For now, we'll just flash a success message
        // In production, you would send an email or store in database
        // Mail::to(config('mail.admin_address'))->send(new ContactFormMail($validated));

        return back()->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
    }
}
