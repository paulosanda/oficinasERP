<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActiveCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $isActiveCompany = $user->company->active;

        if ($isActiveCompany) {
            return $next($request);
        } else {
            return response('O acesso de sua empresa está bloqueado.', Response::HTTP_FORBIDDEN);

        }

    }
}
