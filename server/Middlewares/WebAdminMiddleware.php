<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

class WebAdminMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $session = $request->getSession();
        // 0 es administrador
        if (!$session->has("id") || $session->get("role") !== 0) {
            $response->redirect("/");
            return;
        }
        $next();
    }
}
