<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
use \Bitrix\Main\Application;
/**
 * @var CMain $APPLICATION
 */

$APPLICATION->IncludeComponent(
    'Otus:exchangeRate',
    '',
    [
        'CURRENCY' => 'USD',
    ]
);