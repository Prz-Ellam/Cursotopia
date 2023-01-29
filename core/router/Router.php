<?php

namespace Bloom\router;

use Bloom\http\HttpMethod;
use Closure;

class Router {

    protected array $routes = [];

    public function __construct() {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    public function add(HttpMethod $method, string $uri, Closure $callable) {
        $this->routes[$method->value][$uri] = $callable;
    }

    public function get(string $uri, Closure $callable) {
        $this->add(HttpMethod::GET, $uri, $callable);
    }

    public function post(string $uri, Closure $callable) {
        $this->add(HttpMethod::POST, $uri, $callable);
    }

    public function put(string $uri, Closure $callable) {
        $this->add(HttpMethod::PUT, $uri, $callable);
    }

    public function patch(string $uri, Closure $callable) {
        $this->add(HttpMethod::PATCH, $uri, $callable);
    }

    public function delete(string $uri, Closure $callable) {
        $this->add(HttpMethod::DELETE, $uri, $callable);
    }

    public function resolve(HttpMethod $method, string $uri) {

    }

}
