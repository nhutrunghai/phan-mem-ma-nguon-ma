<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('admin_authenticated') === true) {
            $adminUserId = $request->session()->get('admin_user_id');

            if ($adminUserId !== null) {
                $admin = User::query()->find((string) $adminUserId);

                if (! $admin || ($admin->role ?? 'user') !== 'admin' || ($admin->status ?? true) === false) {
                    $request->session()->forget(['admin_authenticated', 'admin_email', 'admin_user_id']);

                    return redirect()->route('admin.login')->with('status', 'Tài khoản quản trị không còn hiệu lực.');
                }
            }

            return $next($request);
        }

        return redirect()->route('admin.login')->with('status', 'Vui lòng đăng nhập quản trị.');
    }
}
