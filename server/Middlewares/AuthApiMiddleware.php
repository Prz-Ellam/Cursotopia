<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

/**
 * Verifica si un usuario se encuentra autenticado en la api
 * Recibe de parametro si el usuario debe o no estar autenticado para continuar
 */
class AuthApiMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next, array $args) {
        $needAuth = $args[0] ?? true;
        $needRole = $args[1] ?? null;

        $session = $request->getSession();
        $authenticated = $session->has("id");
        $role = $session->get("role");

        if ($authenticated != $needAuth) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "No autorizado"
            ]);
            return;
        }
        if ($needRole && $role != $needRole) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "No autorizado"
            ]);
            return;
        }
        $next();
    }
}
