<?php

namespace Bloom\http\request;

class Request {
    private array $queryParameters;
    private array $body;
    private array $routeParameters;
    private array $headers;
    private array $files;

    /**
     * Return body parameter
     *
     * @param string|null $name
     * @return array|string|null
     */
    public function getBody(?string $name = null): array|string|null {
        if (is_null($name)) {
            return $this->body;
        }
        return $this->body[$name] ?? null;
    }
}
