<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login dan role-nya sesuai
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Jika tidak sesuai, arahkan ke dashboard masing-masing atau ke home
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses.');
    }
}