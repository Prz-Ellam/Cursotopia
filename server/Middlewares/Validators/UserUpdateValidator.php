<?php

namespace Cursotopia\Middlewares\Validators;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

class UserUpdateValidator implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $updateUserSchema = <<<'JSON'
        {
            "$error": {
                "required": "Incluir las propiedades: [{missing}]",
                "additionalProperties": "Propiedades extra: [{properties}]"
            },
            "type": "object",
            "properties": {
                "name": {
                    "type": "string",
                    "maxLength": 50,
                    "$error": {
                        "type": "El nombre debe ser una cadena de texto",
                        "maxLength": "El nombre es muy largo, solo {max} caracteres son admitidos, se encontraron {length}"
                    }
                },
                "lastName": {
                    "type": "string",
                    "maxLength": 50
                },
                "birthDate": {
                    "type": "string",
                    "format": "date"
                },
                "gender": {
                    "type": "number"
                },
                "email": {
                    "type": "string",
                    "maxLength": 255,
                    "format": "email"
                }
            },
            "required": [
                "name", 
                "lastName", 
                "birthDate", 
                "gender", 
                "email"
            ],
            "additionalProperties": false
        }
        JSON;

        $body = $request->getBody();

        $validator = new Validator();
        $validator->setMaxErrors(100);
        $formatter = new ErrorFormatter();
        $result = $validator->validate((object)$body, json_decode($updateUserSchema));

        if ($result->hasError()) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => $formatter->format($result->error(), false)
                ]);
            return;
        }

        $next($request, $response);
    }
}
