<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Exception;

class PayloadMiddleware implements Middleware {
    public function handle(Request $request, Response $response, Closure $next, array $args): void {
        //try {
            $payload = $request->getBody("payload", null);
            if ($payload) {
                $bodyPayload = json_decode($payload, true);
                if ($bodyPayload) {
                    $request->setBody($bodyPayload);
                    $next();
                    return;
                }
            }
            $response->json([
                "status" => false,
                "message" => "Error"
            ]);
            return;

        //}
        //catch (Exception $exception) {

        //}
    }
}
