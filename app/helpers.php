<?php

function view($name, $attributes = []) {
    extract($attributes);

    return require APP_ROOT . "views/{$name}.view.php";
}

function redirect($route) {
    return header("Location:" . APP_URL . $route);
}

function sanitize($value) {
    return trim(htmlspecialchars($value));
}

function csrf() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_expire'] = time() + 3600; // 1 hour
        return $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function isValidCsrf($token)
{
    if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_expire']) {
        if (time() > $_SESSION['csrf_expire']) {
            unset($_SESSION['csrf_token']);
            unset($_SESSION['csrf_expire']);

            return false;
        }

        return hash_equals($token, $_SESSION['csrf_token']);
    }

    return false;
}

function invalidateCsrf()
{
    if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_expire']) {
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_expire']);

        return true;
    }

    return false;
}