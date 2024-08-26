<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

spl_autoload_register(function ($class): void {
    if(!str_contains($class, 'otus')) {
        return;
    }

    $class = str_replace('\\', '/', $class);

    $path = __DIR__ . '/' . $class . '.php';

    if(file_exists($path)) {
        require_once $path;
    }
});