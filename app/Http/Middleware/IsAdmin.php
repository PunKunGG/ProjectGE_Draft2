<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,string $role)
    {
        if (auth()->user()->role === 'super-admin') {
            return $next($request);
        }

        // 2. ถ้าไม่ใช่ super-admin ก็ให้เช็คสิทธิ์ตามปกติ
        if (auth()->user()->role !== $role) {
            return redirect('dashboard')->with('error', 'ไม่มีสิทธิเข้าถึง');
        }

        return $next($request);
        
    }
}
