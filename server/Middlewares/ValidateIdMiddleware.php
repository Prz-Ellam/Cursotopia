<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

class ValidateIdMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $id = $request->getParams("id");
        if (!((is_int($id) || ctype_digit($id)) && intval($id) > 0)) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "El id debe ser un número entero positivo"
                ]);
            return;
        }
        $next();
    }
}
