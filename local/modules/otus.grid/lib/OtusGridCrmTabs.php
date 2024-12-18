<?php
namespace Otus\Grid;
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;

class OtusGridCrmTabs
{
    static function setCustomTabs(\Bitrix\Main\Event $event): \Bitrix\Main\EventResult
    {
        $entityId = $event->getParameter('entityID');
        $tabs = $event->getParameter('tabs');

        //var_dump($tabs);

        $tabs[] = [
            'id' => 'component_users',
            'name' => 'Таблица',
            'enabled' => !empty($entityId),
            'loader' => [
                'serviceUrl' => '/bitrix/components/otus/grid.table/lazyload.ajax.php?' . \bitrix_sessid_get(),
                'componentData' => [
                    'template' => '',
                    'params' => []
                ]
        ]];

        return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
            'tabs' => $tabs,
        ]);
    }
}