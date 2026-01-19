<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        // Não autenticado
        if (! $user) {
            abort(401);
        }

        // Sem permissão
        if (! $user->hasPermission($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
