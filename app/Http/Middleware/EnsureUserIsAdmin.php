<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        try {
            Log::info('Starting admin check');
            
            if (!Auth::check()) {
                Log::info('User not authenticated, redirecting to login');
                return redirect()->route('filament.admin.auth.login');
            }

            $user = Auth::user();
            Log::info('User info', [
                'id' => $user->id,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'raw_attributes' => $user->getAttributes()
            ]);

            if (!$user->is_admin) {
                Log::warning('Non-admin access attempt', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                abort(403, 'You do not have admin access.');
            }

            Log::info('Admin access granted');
            return $next($request);
        } catch (\Exception $e) {
            Log::error('Error in admin middleware', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
} 