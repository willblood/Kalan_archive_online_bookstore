<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    // Validate the request data
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8', // Password is optional
        'is_admin' => 'required|boolean', // 'is_admin' is required and must be a boolean
    ]);

    // Check if a password is provided
    if (!empty($data['password'])) {
        // If password is given, hash it
        $data['password'] = bcrypt($data['password']);
    } else {
        // If no password is provided, remove the 'password' key from $data
        unset($data['password']);
    }

    // Update the user with the validated data
    $user->update($data);

    // Redirect back to the users index page with a success message
    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
