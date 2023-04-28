<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Helpers\Validate;

class ValidateIdMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next, array $args) {
        $id = $request->getParams("id");
        if (!Validate::uint($id)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "El id debe ser un número entero positivo"
            ]);
            return;
        }
        $next();
    }
}
