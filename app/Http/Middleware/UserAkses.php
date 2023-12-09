<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Jika $role adalah array, gunakan contains untuk memeriksa apakah user memiliki setidaknya satu dari role tersebut
        if (is_array($role) && auth()->user()->roles->pluck('name')->contains($role)) {
            return $next($request);
        }
        // Jika $role adalah string, langsung cek apakah user memiliki role tersebut
        elseif (is_string($role) && auth()->user()->roles->pluck('name')->contains($role)) {
            return $next($request);
        }

        return redirect('/home');
    }
}
