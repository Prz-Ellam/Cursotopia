<?php

namespace Cursotopia\Middlewares\Validators;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

class UserUpdatePasswordValidator implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        $updatePasswordSchema = <<<'JSON'
        {
            "$error": {
                "required": "Incluir las propiedades: [{missing}]",
                "additionalProperties": "Propiedades extra: [{properties}]"
            },
            "type": "object",
            "properties": {
                "oldPassword": {
                    "type": "string",
                    "maxLength": 255,
                    "$error": {
                        "type": "El nombre debe ser una cadena de texto",
                        "maxLength": "El nombre es muy largo, solo {max} caracteres son admitidos, se encontraron {length}"
                    }
                },
                "newPassword": {
                    "type": "string",
                    "maxLength": 255
                },
                "confirmNewPassword": {
                    "type": "string",
                    "maxLength": 255,
                    "const": {
                        "$data": "/newPassword"
                    },
                    "$error": {
                        "type": "La confirmación de contraseña debe ser una cadena de texto",
                        "maxLength": "La confirmación de  contraseña es muy larga, solo {max} caracteres son admitidos, se encontraron {length}",
                        "const": "La confirmación de contraseña no coincide con la contraseña"
                    }
                }
            },
            "required": [
                "oldPassword", 
                "newPassword", 
                "confirmNewPassword"
            ],
            "additionalProperties": false
        }
        JSON;

        $body = $request->getBody();

        $validator = new Validator();
        $validator->setMaxErrors(100);
        $formatter = new ErrorFormatter();
        $result = $validator->validate((object)$body, json_decode($updatePasswordSchema));

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
