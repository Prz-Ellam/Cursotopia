<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

class ApiInstructorMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next, array $args) {
        $session = $request->getSession();
        // 2 es instructor
        if (!$session->has("id") || $session->get("role") !== 2) {
            $response
                ->setStatus(401)
                ->json([
                    "status" => false,
                    "message" => "Unauthorized"
                ]);
            return;
        }
        $next();
    }
}
