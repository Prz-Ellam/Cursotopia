<?php

namespace Cursotopia\Routes;

use Cursotopia\Controllers\HomeController;
use Cursotopia\Middlewares\HasNotAuthMiddleware;

$app->get("/", [ HomeController::class, "redirect" ]);

$app->get("/home", [ HomeController::class, "home" ]);

