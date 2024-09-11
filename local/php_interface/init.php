<?php
define('DEBUG_FILE_NAME', $_SERVER["DOCUMENT_ROOT"] .'/logs/'.date("Y-m-d").'.log');

if (file_exists(__DIR__ . '/classes/autoload.php')) {
    require_once __DIR__ . '/classes/autoload.php';
}

\Otus\Diagnostic\Helper::writeToLog('Hello, world!');


//throw new \Exception('Hello, world!');

require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Registry;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = Registry::getInstance('app');

// Write info message with context: invalid message from feedback
$logger->error('Failed create new message on feedback form', array(
    'item_id' => 21,
    'Invalid data' => "Ошибка", // error savings
    'Form data' => "Дата" // data from feedback form
));