<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';

    require_once $file;
});
