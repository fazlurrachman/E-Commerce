<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //middleware untuk pengecekan
        //Pengecekan apakah user yang login adalah admin
        if (Auth::user() && Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'OWNER') {
            return $next($request);
        }

        //jika bukan admin redirect ke halaman utama
        return redirect('/');
    }
}
