<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

class ApiInstructorMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $session = $request->getSession();
        // 1 es instructor
        if (!$session->has("id") || $session->get("role") !== 1) {
            $response->redirect("/");
            return;
        }
        $next();
    }
}
