<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class FirstGrid extends CBitrixComponent
{
    //private $_request;

    /**
     * Проверка наличия модулей требуемых для работы компонента
     * @return void
     * @throws Exception
     */
    private function _checkModules(): void
    {
        if (!Loader::includeModule('iblock')
            || !Loader::includeModule('sale')
        ) {
            throw new \Exception('Не загружены модули необходимые для работы модуля');
        }
    }

    /**
     * Обертка над глобальной переменной
     * @return CAllMain|CMain
     */
    private function _app(): CAllMain|CMain
    {
        global $APPLICATION;
        return $APPLICATION;
    }

    /**
     * Обертка над глобальной переменной
     * @return CAllUser|CUser
     */
    private function _user(): CAllUser|CUser
    {
        global $USER;
        return $USER;
    }

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        return [
            'CACHE_TIME' => $arParams['CACHE_TIME'] ?? 36000000,
            'CACHE_TYPE' => $arParams['CACHE_TYPE'] ?? 'A',
        ];
    }


    private function getHeaders()
    {
        return [
            [
                'id' => 'DOCTORS_ID',
                'name' => 'ID доктора',
                'sort' => 'DOCTORS_ID',
                'default' => true,
            ],
            [
                'id' => 'DOCTORS_NAME',
                'name' => 'Доктор',
                'sort' => 'DOCTORS_NAME',
                'default' => true,
            ],
            [
                'id' => 'PROCEDURES_NAME',
                'name' => 'Процедуры',
                'sort' => 'PROCEDURES_NAME',
                'default' => true,
            ]
        ];
    }

    /**
     * Точка входа в компонент
     * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
     * всю логику стараемся разносить по классам и методам
     * @throws Exception
     */
    public function executeComponent(): void
    {
        $this->_checkModules();

        //$this->_request = Application::getInstance()->getContext()->getRequest();

        $this->arResult['HEADERS'] = $this->getHeaders();
        $this->arResult['FILTER_ID'] = 'DOCTORS_GRID';

        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $select = [
                'ID',
                'NAME',
                'PROCEDURES.ELEMENT.NAME'
            ];
            $iblock = '\Bitrix\Iblock\Elements\ElementDoctorsTable';

            $result = $iblock::query()
                ->setSelect($select)
                ->fetchCollection();

            foreach ($result as $doctor) {
                $procedures = '';
                foreach ($doctor->getProcedures() as $procedure) {
                    $procedures .= $procedure->getElement()->getName() . "<br>";
                }

                $this->arResult['GRID_LIST'][] = [
                    'data' => [
                        'DOCTORS_ID' => $doctor->getId(),
                        'DOCTORS_NAME' => $doctor->getName(),
                        'PROCEDURES_NAME' => $procedures,
                    ],
                    'attributes' => [
                        'data-id' => $doctor->getId(), // Добавляем атрибут data-id
                    ]
                ];
            }
        }

        $this->includeComponentTemplate();
    }
}