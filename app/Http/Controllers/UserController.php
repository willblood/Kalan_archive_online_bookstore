<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function loginView()
    {
        $viewData=[];
        $viewData['title']="Login";
        return view("login")
        ->with("viewData", $viewData);
    }

    public function registerView()
    {
        $viewData=[];
        $viewData['title']="Sign Up";
        return view("signup")
        ->with("viewData", $viewData);
    }


    public function register(Request $request)
    {
        $incomingFiled = $request->validate(
            [
                "name" => ["required", "string", "min:2", "max:70"],
                "email" => ["required", "email", Rule::unique("users", "email")],
                "password" => ["required", "string", "min:8", "max:100"]
            ]
        );

        $incomingFiled["password"] = bcrypt($incomingFiled["password"]);
        $user = User::create($incomingFiled);
        auth()->login($user);
        return redirect("/");
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function login(Request $request)
    {
        $incomingField = $request->validate([
            "email" => ["required", "string"],
            "password" => ["required", "string"],
        ]);

        // Pass email and password as an associative array
        if (auth()->attempt([
                'email' => $incomingField['email'],
                'password' => $incomingField['password']
            ])
        ) {
            $request->session()->regenerate();
            return redirect("/");  // Redirect to home/dashboard after successful login
        }

        return redirect("/login-form")->withErrors(['login' => 'Invalid credentials.'])->withInput();
    }
}
