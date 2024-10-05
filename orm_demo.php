<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

use Bitrix\Iblock\ORM\PropertyValue;
use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost() && check_bitrix_sessid()) {
    echo "<pre>";
    print_r($request->getPostList());
    echo "</pre>";
    if ($request->getPost('apply') && $request->getPost('TYPE') === "DOCTOR") {
        $iblockId = 16;
        $iblock = \Bitrix\Iblock\Iblock::wakeUp($iblockId);
        $newDoctor = $iblock->getEntityDataClass()::createObject();
        $newDoctor->setName($request->getPost('NAME'));
        $newDoctor->save();
        foreach ($request->getPost('PROCEDURES') as $key => $value) {
            $newDoctor->addToProcedures(new PropertyValue($value));
        }
        $newDoctor->save();
    }elseif($request->getPost('apply') && $request->getPost('TYPE') === "PROCEDURES"){
        $iblockId = 17;
        $iblock = \Bitrix\Iblock\Iblock::wakeUp($iblockId);
        $newProcedures = $iblock->getEntityDataClass()::createObject();
        $newProcedures->setName($request->getPost('NAME'));
        $newProcedures->save();
    }
}

if (isset($_REQUEST["IFRAME"]) && $_REQUEST["IFRAME"] === "Y" && !$request->isPost()) {
    if (isset($_REQUEST["TYPE"]) && $_REQUEST["TYPE"] === "DOCTOR") {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        $APPLICATION->SetTitle('Добавить врача');

        $iblock = '\Bitrix\Iblock\Elements\ElementProceduresTable';

        $procedures = $iblock::query()
            ->setSelect([
                'ID',
                'NAME',
            ])
            ->fetchAll();

        if (empty($procedures)) {
            $procedures = [];
        }

        $proceduresSelect = array_map(
                function ($procedure) {
                    return "<option value='{$procedure['ID']}'>{$procedure['NAME']}</option>";
                },
                $procedures);

        $proceduresSelectHtml = '<select name="PROCEDURES[]" multiple="multiple">
                                ' . implode('', $proceduresSelect) . '
                            </select>';

//        $proceduresSelectHtml = '<div id="procedures"></div>
//<script>
//            BX.Runtime.loadExtension(\'ui.entity-selector\').then(exports => {
//                const { TagSelector } = exports;
//
//                // Создание экземпляра TagSelector
//                const tagSelector = new TagSelector({
//                    dialogOptions: {
//                        context: \'MY_MODULE_CONTEXT\',
//                        entities: [
//                            { id: \'iblock-element\',
//                             options:{
//                                iblockId: 17,
//                             }},
//                        ],
//                    },
//                });
//
//                // Отображение TagSelector в контейнере
//                const proceduresContainer = document.getElementById(\'procedures\');
//                if (proceduresContainer) {
//                    tagSelector.renderTo(proceduresContainer);
//                } else {
//                    console.error(\'Контейнер для TagSelector не найден.\');
//                }
//            }).catch(error => {
//                console.error(\'Ошибка при загрузке библиотеки ui.entity-selector:\', error);
//            });
//</script>';

        $tabs = [
            [
                "id" => "tab1",
                "name" => "Добавить врача",
                "fields" => [
                    [
                        "id" => "NAME",
                        "name" => "Имя",
                        "type" => "text",
                    ],
                    [
                        "id" => "PROCEDURES",
                        "name" => "Процедуры",
                        "type" => "custom",
                        "value" => $proceduresSelectHtml,
                    ],
                    [
                        "id" => "TYPE",
                        "type" => "custom",
                        "value" => '<input type="hidden" name="TYPE" value="DOCTOR">'
                    ],
                    [
                        "id" => "ID",
                        "type" => "custom",
                        "value" => '<input type="hidden" name="ID">'
                    ]
                ]
            ]
        ];

        $buttons = [
            "standard_buttons" => true,
            "custom_html" => '<input type="button" onclick="BX.SidePanel.Instance.close();" value="Закрыть">'
        ];

        $APPLICATION->IncludeComponent(
            'bitrix:ui.sidepanel.wrapper',
            '',
            [
                'POPUP_COMPONENT_NAME' => 'bitrix:main.interface.form',
                'POPUP_COMPONENT_TEMPLATE_NAME' => '',
                'POPUP_COMPONENT_PARAMS' => [
                    "FORM_ID" => "doctor_edit_form",
                    "TABS" => $tabs,
                    "BUTTONS" => $buttons,
                    "DATA" => []
                ]
            ]
        );
        die();
    }elseif (isset($_REQUEST["TYPE"]) && $_REQUEST["TYPE"] === "PROCEDURES"){
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        $APPLICATION->SetTitle('Добавить процедуру');

        $tabs = [
            [
                "id" => "tab2",
                "name" => "Добавить процедуру",
                "fields" => [
                    [
                        "id" => "NAME",
                        "name" => "Процедура",
                        "type" => "text",
                    ],
                    [
                        "id" => "TYPE",
                        "type" => "custom",
                        "value" => '<input type="hidden" name="TYPE" value="PROCEDURES">'
                    ],
                    [
                        "id" => "ID",
                        "type" => "custom",
                        "value" => '<input type="hidden" name="ID">'
                    ]
                ]
            ]
        ];

        $buttons = [
            "standard_buttons" => true,
            "custom_html" => '<input type="button" onclick="BX.SidePanel.Instance.close();" value="Закрыть">'
        ];

        $APPLICATION->IncludeComponent(
            'bitrix:ui.sidepanel.wrapper',
            '',
            [
                'POPUP_COMPONENT_NAME' => 'bitrix:main.interface.form',
                'POPUP_COMPONENT_TEMPLATE_NAME' => '',
                'POPUP_COMPONENT_PARAMS' => [
                    "FORM_ID" => "procedure_edit_form",
                    "TABS" => $tabs,
                    "BUTTONS" => $buttons,
                    "DATA" => []
                ]
            ]
        );
        die();
    }else{
        $APPLICATION->RestartBuffer(); //сбрасываем весь вывод
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <?php $APPLICATION->ShowHead(); ?>
        </head>
        <body>
        <?php
        \Bitrix\Main\Loader::includeModule('iblock');
        $select = [
            'ID',
            'PROCEDURES.ELEMENT.NAME',
        ];

        $iblock = '\Bitrix\Iblock\Elements\ElementDoctorsTable';
        $_request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

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
        ?>
        </body>
        </html>
        <?php
    }
} else {
    /**
     * @var CMain $APPLICATION
     */
    $APPLICATION->SetTitle('Демонстрация ORM');
    $APPLICATION->IncludeComponent('Otus:first.grid', '');
    require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
}
