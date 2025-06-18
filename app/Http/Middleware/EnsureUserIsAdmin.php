<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Admin middleware check', [
            'is_authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'request_path' => $request->path(),
            'user' => auth()->user(),
        ]);

        // If user is not logged in, let the authentication middleware handle it
        if (!auth()->check()) {
            Log::info('User not authenticated');
            return $next($request);
        }

        $user = auth()->user();
        Log::info('User authenticated', [
            'user_id' => $user->id,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
            'is_admin_type' => gettype($user->is_admin),
        ]);

        // If user is logged in but not admin, show forbidden
        if (!$user->is_admin) {
            Log::warning('Non-admin user attempted to access admin area', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            abort(403, 'Unauthorized. Admin access required.');
        }

        Log::info('Admin access granted', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return $next($request);
    }
} 