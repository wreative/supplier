<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesAlmaas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

        if (Auth::user()->role_id != '2') {
            return redirect('/dashboard')
                ->with(['status' => 'Anda tidak punya akses disini.']);
        }
        return $next($request);
    }
}
