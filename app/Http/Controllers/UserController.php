<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Client;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Show the login form.
     */
    public function loginView(): View
    {
        return view('login', [
            'viewData' => [
                'title' => 'Login'
            ]
        ]);
    }

    /**
     * Show the registration form.
     */
    public function registerView(): View
    {
        return view('signup', [
            'viewData' => [
                'title' => 'Sign Up'
            ]
        ]);
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:70',
                function ($attribute, $value, $fail) {
                    $nameParts = explode(' ', trim($value));
                    if (count($nameParts) < 2) {
                        $fail('Please enter your full name (Last Name First Name).');
                    }
                }
            ],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'max:100']
        ]);

        // Check if the user already exists
        $existingUser = User::where('email', $validated['email'])->first();
        if ($existingUser) {
            return redirect()->back()->withErrors(['email' => 'An account with this email already exists.'])->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        // Send Welcome Email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        Auth::login($user);

        return redirect()->route('home.index')->with('success', 'Registration successful! A welcome email has been sent.');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Revoke Google token if the user logged in via Google
        if (session()->has('google_token')) {
            $token = session()->get('google_token');
            try {
                $client = new Client();
                $client->post('https://accounts.google.com/o/oauth2/revoke', [
                    'form_params' => ['token' => $token],
                ]);
            } catch (\Exception $e) {
                // Log the error or handle it as needed
            }
        }

        // Log out the user
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home.index');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        \Log::info('Login attempt:', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            \Log::info('Login successful:', ['user_id' => Auth::id(), 'is_admin' => Auth::user()->is_admin]);

            // Check if the user is an admin
            if (Auth::user()->is_admin) {
\Log::info('Admin login successful:', ['user_id' => Auth::id()]);
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            }

\Log::info('Regular user login successful:', ['user_id' => Auth::id()]);
            return redirect()->route('home.index'); // Redirect to regular user home
        }

        // Log the failed login attempt
        \Log::warning('Login failed:', ['email' => $credentials['email']]);

        // Redirect back with an error message
        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
    }

    /**
     * Show the account settings form.
     */
    public function edit()
    {
        return view('account.settings', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the account settings.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? $user->phone;

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('account.settings')->with('success', 'Account updated successfully.');
    }
}
