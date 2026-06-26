<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roleString  // Menangkap string role dari web.php (misal: "pengawas|pencatat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $roleString): Response
    {
        // 1. Cek apakah user sudah login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // 2. Pecah string "pengawas|pencatat" menjadi array ['pengawas', 'pencatat']
        $roles = explode('|', $roleString);

        // 3. Cek AKURAT berdasarkan kolom role di database
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}