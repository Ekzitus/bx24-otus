<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

class OtusGridTable extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['TABLE_NAME'] = Option::get("otus.grid", "test", "b_iblock_type");
        return $arParams;
    }

    public function executeComponent()
    {
        $tableName = $this->arParams['TABLE_NAME'];

        if (empty($tableName)) {
            $this->arResult['ERROR'] = "Не указано имя таблицы в опциях модуля";
        } else {
            global $DB;
            $rs = $DB->Query("SELECT * FROM " . $tableName);
            $rows = [];
            while ($row = $rs->Fetch()) {
                $rows[] = $row;
            }

            $this->arResult['TABLE_DATA'] = $rows;
        }

        $this->IncludeComponentTemplate();
    }
}
?>