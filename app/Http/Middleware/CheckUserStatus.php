<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Nếu là admin thì không check (tuỳ bạn kiểm tra theo role name hoặc role_id)
            if ($user->role && $user->role->name === 'admin') {
                return $next($request); // Bỏ qua middleware với admin
            }

            // Nếu tài khoản không hoạt động thì logout
            if ($user->status === 'inactive') {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Tài khoản của bạn hiện không hoạt động.',
                ]);
            }
        }

        return $next($request);
    }
}
