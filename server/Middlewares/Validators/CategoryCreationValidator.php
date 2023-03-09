<?php

namespace Cursotopia\Middlewares\Validators;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

class CategoryCreationValidator implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $categoryCreationSchema = <<<'JSON'
        {
            "$error": {
                "required": "Incluir las propiedades: [{missing}]",
                "additionalProperties": "Propiedades extra: [{properties}]"
            },
            "type": "object",
            "properties": {
                "name": {
                    "type": "string",
                    "maxLength": 255,
                    "$error": {
                        "type": "El nombre debe ser una cadena de texto",
                        "maxLength": "El nombre es muy largo, solo {max} caracteres son admitidos, se encontraron {length}"
                    }
                },
                "description": {
                    "type": "string",
                    "maxLength": 255,
                    "$error": {
                        "type": "La descripción debe ser una cadena de texto",
                        "maxLength": "El descripción es muy larga, solo {max} caracteres son admitidos, se encontraron {length}"
                    }
                }
            },
            "required": [ "name", "description" ],
            "additionalProperties": false
        }
        JSON;

        $body = $request->getBody();

        $validator = new Validator();
        $validator->setMaxErrors(100);
        $formatter = new ErrorFormatter();
        $result = $validator->validate((object)$body, json_decode($categoryCreationSchema));

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
