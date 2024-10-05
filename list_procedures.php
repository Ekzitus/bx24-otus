<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
use \Bitrix\Main\Application;
/**
 * @var CMain $APPLICATION
 */

\Bitrix\Main\Loader::includeModule('iblock');
$select = [
    'ID',
    'PROCEDURES.ELEMENT.NAME',
];

$iblock = '\Bitrix\Iblock\Elements\ElementDoctorsTable';
$_request = Application::getInstance()->getContext()->getRequest();

$query = $_request->getQuery("id");

$result = $iblock::query()
    ->setSelect($select)
    ->setFilter(["=ID" => $query])
    ->fetchCollection();
$procedureName = "";
foreach ($result as $doctor) {
    $procedures = $doctor->getProcedures();
    foreach ($procedures as $procedure) {
        $procedureName .= $procedure->getElement()->getName() . "<br>";
    }
}

echo '<pre>';
echo $procedureName;
echo '</pre>';

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');