<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role != "Administrador")
            return response()->json([
                "success" => false,
                "message" => "Necesitas permisos de Administrador para acceder a este recurso.",
                "errors" => ["Necesitas permisos de Administrador para acceder a este recurso."],
                "data" => null
            ]);
        return $next($request);
    }
}
