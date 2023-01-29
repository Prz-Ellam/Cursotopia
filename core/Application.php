<?php

namespace Bloom;

use Bloom\http\request\Request;
use Bloom\router\Router;
use Closure;

/**
 * Basic kernel of the application
 */
class Application {

    private static ?self $instance = null;

    private Router $router;

    private Request $request;

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
        $this->router->get($uri, $callable);
    }

    public function post(string $uri, Closure $callable) {
        $this->router->post($uri, $callable);
    }

    public function put(string $uri, Closure $callable) {
        $this->router->put($uri, $callable);
    }

    public function patch(string $uri, Closure $callable) {
        $this->router->patch($uri, $callable);
    }

    public function delete(string $uri, Closure $callable) {
        $this->router->delete($uri, $callable);
    }

    public function run() {
        var_dump($this->router);
    }

}
