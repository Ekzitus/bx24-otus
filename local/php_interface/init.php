<?php
define('DEBUG_FILE_NAME', $_SERVER['DOCUMENT_ROOT'] . '/logs/' . date("Y-m-d") . '.log');

if (file_exists('autoload.php')) {
    require_once __DIR__ . '/autoload.php';
}

\otus\diagnostic\Helper::writeToLog("Hello World!");