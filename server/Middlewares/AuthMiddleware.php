<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

// ApiAuthMiddleware
class AuthMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $session = $request->getSession();
        if (!$session->has("id")) {
            $response
                ->setStatus(401)
                ->json([
                    "status" => false,
                    "message" => "Unauthorized"
                ]);
            return;
        }
        $next($request, $response);
    }
}
