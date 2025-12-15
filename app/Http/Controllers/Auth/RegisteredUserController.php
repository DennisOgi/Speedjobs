<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:jobseeker,employer'],
            'university' => ['nullable', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'integer', 'min:0', 'max:' . (date('Y') + 10)],
            'skills' => ['nullable', 'string'],
            'experience_level' => ['nullable', 'in:entry,intermediate,senior'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'location' => $request->location,
        ];

        // Only add jobseeker-specific fields if role is jobseeker
        if ($request->role === 'jobseeker') {
            $userData['university'] = $request->university;
            $userData['field_of_study'] = $request->field_of_study;
            $userData['graduation_year'] = $request->graduation_year;
            $userData['skills'] = $request->skills;
            $userData['experience_level'] = $request->experience_level ?? 'entry';
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'employer') {
            return redirect(route('employer.dashboard', absolute: false));
        }

        return redirect(route('dashboard', absolute: false));
    }
}
