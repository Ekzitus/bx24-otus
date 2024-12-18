<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * */

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    "GROUPS" => [
        "SETTINGS" => [
            "NAME" => 'Настройки',
            "SORT" => 550,
        ],
    ],
];