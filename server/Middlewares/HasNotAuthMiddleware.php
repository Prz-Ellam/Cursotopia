<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

class HasNotAuthMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $session = $request->getSession();
        if (!$session->has("id")) {
            $response->redirect("/");
            return;
        }
        $next($request, $response);
    }
}
