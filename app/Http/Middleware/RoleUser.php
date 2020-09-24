<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $role = ($role == 'admin') ? true : false;
        if (Auth::user()->isAdmin == $role) {
            return $next($request);
        }
        return response()->json(["message" => 'No autorizado'], 403);
    }
}
