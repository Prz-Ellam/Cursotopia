<?php

namespace Bloom;

use Bloom\router\Router;
use Closure;

/**
 * Basic kernel of the application
 */
class Application {

    private static self $instance;

    private Router $router;

    private function __construct() {
        $this->router = new Router();
    }

    public static function app(): self {
        if (self::$instance == null) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

    public function get(string $uri, Closure $callable) {
        $this->router->get();
    }

    public function post(string $uri, Closure $callable) {
        $this->router->post();
    }

    public function put(string $uri, Closure $callable) {
        $this->router->put();
    }

    public function patch(string $uri, Closure $callable) {
        $this->router->patch();
    }

    public function delete(string $uri, Closure $callable) {
        $this->router->delete();
    }

}
