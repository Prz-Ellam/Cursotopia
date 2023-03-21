<?php

namespace Cursotopia\Helpers;

use Bloom\Application;

class Auth {
    public static function auth(?int $role = null) {
        $session = Application::app()->getSession();
        if (is_null($role)) {
            return $session->has("id");
        }
        return $session->has("id") && $session->get("role") == $role;
    }
}
