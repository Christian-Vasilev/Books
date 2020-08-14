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