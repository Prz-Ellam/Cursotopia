<?php

namespace Cursotopia\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

class JsonSchemaMiddleware {
    public function handle(Request $request, Response $response, Closure $next, array $args) {
        if (count($args) < 1) {
            $response
                ->setStatus(500)
                ->json([
                    "status" => false,
                    "message" => "Unexpected server error"
                ]);
            return;
        }

        $json = file_get_contents(__DIR__ . "/Validators/" . $args[0] . ".json");
        $body = $request->getBody();

        $validator = new Validator();
        $validator->setMaxErrors(100);
        $formatter = new ErrorFormatter();
        $result = $validator->validate((object)$body, json_decode($json));

        if ($result->hasError()) {
            $response
                ->setStatus(422)
                ->json([
                    "status" => false,
                    "message" => $formatter->format($result->error(), false)
                ]);
            return;
        }

        $next();
    }
}
