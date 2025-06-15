<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        if ($user->role === 'honorer') {
            return redirect()->back()->withErrors([
                'email' => 'Akses tidak diizinkan.',
            ]);
        }

        return redirect()->back()->with('error', 'Akses tidak diizinkan.');
        // return abort(403, 'Unauthorized');
    }
}
