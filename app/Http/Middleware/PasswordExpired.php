<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

class PasswordExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $password_changed = new Carbon(($user->password_changed) ? $user->password_changed : $user->created_at);

        if (config('auth.password_expires_days_enabled') && Carbon::now()->diffInDays($password_changed) >= config('auth.password_expires_days')) {

            $token = Password::createToken($user);
            return response()->json([
                'code' => Response::HTTP_BAD_REQUEST,
                'status' => 'failed',
                'message' => __('passwords.expired'),
                'access_token' => $token,
                'token_ziyl' => '',
                'token_type' => 'api',
                'expires_in' => config('auth.passwords.users.expire'),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
