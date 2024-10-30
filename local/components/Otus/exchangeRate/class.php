<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ExchangeRate extends CBitrixComponent
{
    public function executeComponent(): void
    {
        $currency = substr($this->arParams['CURRENCY'], 0, 3);
        if( !Loader::includeModule('currency') ) {
            throw new \Exception('Не загружены модули необходимые для работы компонента');
        }
        $rsCurrencyRate = \Bitrix\Currency\CurrencyRateTable::getList([
            'select'  => ['RATE', 'BASE_CURRENCY', 'DATE_CREATE'], // имена полей, которые необходимо получить в результате
            'filter'  => ['CURRENCY' => $currency], // описание фильтра для WHERE и HAVING
            'order'   => ['DATE_CREATE' => 'DESC'], // параметры сортировки
            'limit'   => 1 // количество записей
        ]);
        while($currencyRate=$rsCurrencyRate->fetch())
        {
            $this->arResult['CURRENCY'] = $currency;
            $this->arResult['RATE'] = $currencyRate['RATE'];
            $this->arResult['BASE_CURRENCY'] = $currencyRate['BASE_CURRENCY'];
            $this->arResult['DATE_CREATE'] = $currencyRate['DATE_CREATE'];
        }
        $this->includeComponentTemplate();
    }
}