<?php
define('DEBUG_FILE_NAME', $_SERVER["DOCUMENT_ROOT"] .'/logs/'.date("Y-m-d").'.log');

if (file_exists(__DIR__ . '/classes/autoload.php')) {
    require_once __DIR__ . '/classes/autoload.php';
}

require_once __DIR__ . '/vendor/autoload.php';

// Проверяем, существует ли класс MyClass
//if (class_exists('Otus\ORM\OrdersTable')) {
//
//} else {
//    echo "Класс MyClass не существует.";
//}

//\Otus\Diagnostic\Helper::writeToLog('Hello, world!');


//throw new \Exception('Hello, world!');

//use Monolog\Registry;
//use Monolog\Handler\StreamHandler;
//use Monolog\Logger;

//$logger = Registry::getInstance('feedback');

// Write info message with context: invalid message from feedback
//$logger->error('Failed create new message on feedback form', array(
//    'item_id' => 21,
//    'Invalid data' => "Ошибка", // error savings
//    'Form data' => "Дата" // data from feedback form
//));