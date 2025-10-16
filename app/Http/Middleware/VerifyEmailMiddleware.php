<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerifyEmailMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
