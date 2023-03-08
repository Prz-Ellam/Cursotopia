<?php

include_once "./vendor/autoload.php";

use Opis\JsonSchema\Validator;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Errors\ValidationError;

$validator = new Validator();
$validator->setMaxErrors(100);

$schema = <<<'JSON'
{
    "$error": {
        "required": "Please provide ({missing})",
        "additionalProperties": "Estan de mas ({properties})"
    },
    "type": "object",
    "properties": {
        "name": {
            "$error": {
                "type": "Name should be a string",
                "minLength": "Name length must be at least {min} chars, found {length}",
                "maxLength": "Name is too long, only {max} chars are allowed, found {length}"
            },
            "type": "string",
            "minLength": 3,
            "maxLength": 5
        },
        "age": {
            "$error": {
                "minimum": "You must be at least {min} years long"
            },
            "type": "number",
            "minimum": 18
        }
    },
    "required": ["name", "age"],
    "additionalProperties": false
}
JSON;

$schema = json_decode($schema);

$formatter = new ErrorFormatter();
$custom = function (ValidationError $error) use ($formatter) {
    return $error->args();
};

$result = $validator->validate((object)[
    'name' => "E",
    'age' => 2,
    "s" => "d",
    "g" => 5
], $schema);
echo json_encode($formatter->format($result->error(), false), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
/*
echo json_encode(
    array_values($formatter->format($result->error(), false)), 
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

*/




// $result = $validator->validate((object)[
//     'name' => 12 // not a string
// ], $schema);
// echo json_encode($formatter->format($result->error(), false), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);


// $result = $validator->validate((object)[
//     'name' => 'op' // too short
// ], $schema);
// echo json_encode($formatter->format($result->error(), false), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);


// $result = $validator->validate((object)[
//     'name' => 'opis/json-schema' // too long
// ], $schema);
// echo json_encode($formatter->format($result->error(), false), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// $result = $validator->validate((object)[
//     'name' => 'opis', // ok
//     'age' => '18', // not a number (default error message)
// ], $schema);
// echo json_encode($formatter->format($result->error(), false), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// $result = $validator->validate((object)[
//     'name' => 'opis', // ok
//     'age' => 10, // too low
// ], $schema);
// echo json_encode($formatter->format($result->error(), false), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// $result = $validator->validate((object)[
//     'name' => 'opis', // ok
//     'age' => 18, // ok
// ], $schema);

// if (!$result->hasError()) {
//     print_r("OK");
// }