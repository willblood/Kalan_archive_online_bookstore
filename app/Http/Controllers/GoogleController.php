<?php



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Retrieve the Google user
            $googleUser = Socialite::driver('google')->stateless()->user();

            Log::info('Google user:', ['user' => $googleUser]);

            // Check if a user with the same Google ID exists
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // Log in the user if found by Google ID
                Auth::login($user);
                Log::info('User found and logged in by Google ID:', ['user' => $user]);
            } else {
                // Check if a user with the same email exists
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    // Update the existing user's Google ID
                    $user->update(['google_id' => $googleUser->id]);
                    Auth::login($user);
                    Log::info('Existing user updated with Google ID and logged in:', ['user' => $user]);
                } else {
                    // Create a new user if no matching email or Google ID is found
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => bcrypt(\Illuminate\Support\Str::random(24)), // Random password for Google users
                    ]);
                    Auth::login($user);
                    Log::info('New user created and logged in:', ['user' => $user]);
                }
            }

            Log::info('Auth user after login:', ['auth_user' => Auth::user()]);

            return redirect()->intended('/');
        } catch (\Exception $e) {
            Log::error('Google Login Error', ['error' => $e->getMessage()]);
            return redirect('/login-form')->with('error', 'Something went wrong with Google login');
        }
    }
}
