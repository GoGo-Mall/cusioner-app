<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {

        $userRole = session('user_role');

        if (!$userRole) {
            return redirect('/login')->with('error', 'Silakan login dulu.');
        }

        // Pastikan $roles selalu berupa array
        $roles = is_array($roles) ? $roles : explode(',', $roles);
        dd($userRole, $roles);


        if (!in_array($userRole, $roles)) {
            return redirect('/login')->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}
