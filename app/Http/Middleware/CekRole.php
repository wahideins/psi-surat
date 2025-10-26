<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CekRole
{
    /**
     * Middleware untuk membatasi akses berdasarkan role dari Firebase
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // 🔹 Ambil data user dari session
        $user = Session::get('user');

        // Jika belum login (tidak ada session user)
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika tidak ada role di session (mungkin gagal sync Firestore)
        if (!isset($user->role)) {
            return redirect()->route('login')->with('error', 'Data role tidak ditemukan. Silakan login ulang.');
        }

        // 🔹 Cocokkan role
        if ($user->role !== $role) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Lanjut jika sesuai
        return $next($request);
    }
}
