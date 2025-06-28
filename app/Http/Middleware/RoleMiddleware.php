<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pega o usuário autenticado pela etapa anterior
        $user = Auth::user();

        // Se o usuário não estiver logado ou não tiver o papel necessário, nega o acesso.
        if (!$user || !$user->hasAnyRole($roles)) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        // Se o usuário tiver o papel, permite que a requisição continue para o controller.
        return $next($request);
    }
}
