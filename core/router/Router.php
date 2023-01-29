<?php

namespace Bloom\router;

use Bloom\http\HttpMethod;

class Router {

    protected array $routes = [];

    public function __construct() {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    public function get() {

    }

    public function post() {

    }

    public function put() {

    }

    public function patch() {

    }

    public function delete() {
        
    }

}
