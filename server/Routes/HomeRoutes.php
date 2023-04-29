<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\HomeController;

$app->get("/", [ HomeController::class, "redirect" ]);

$app->get("/home", [ HomeController::class, "home" ]);

