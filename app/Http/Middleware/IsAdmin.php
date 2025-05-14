<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        \Log::info('IsAdmin middleware triggered.');

        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        \Log::warning('Unauthorized access attempt.', ['user_id' => Auth::id()]);
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
