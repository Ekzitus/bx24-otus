<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const grid = BX.Main.gridManager.getInstanceById('<?= $arResult['FILTER_ID'] ?>');
        grid.getBody().addEventListener('dblclick', (event) => {
            const target = event.target.closest('tr'); // Находим строку
            if (target) {
                const cells = target.querySelectorAll('td');
                const rowId = cells[1].innerText.trim();
                BX.SidePanel.Instance.open('?id=' + rowId);
            }
        });
    });
</script>

<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */

if(\Bitrix\Main\Loader::includeModule('ui')){
    $APPLICATION->IncludeComponent(
        'bitrix:main.ui.grid',
        '',
        [
            'GRID_ID' => $arResult['FILTER_ID'],
            'HEADERS' => $arResult['HEADERS'],
            'ROWS' => $arResult['GRID_LIST'],
            'FILTER_STATUS_NAME' => '',
            'AJAX_MODE' => 'Y',
            'AJAX_OPTION_JUMP' => 'N',
            'AJAX_OPTION_STYLE' => 'N',
            'AJAX_OPTION_HISTORY' => 'N',

            'ALLOW_COLUMNS_SORT' => false,
            'ALLOW_ROWS_SORT' => [],
            'ALLOW_COLUMNS_RESIZE' => false,
            'ALLOW_HORIZONTAL_SCROLL' => true,
            'ALLOW_SORT' => true,
            'ALLOW_PIN_HEADER' => true,
            'ACTION_PANEL' => [],

            'SHOW_CHECK_ALL_CHECKBOXES' => false,
            'SHOW_ROW_CHECKBOXES' => false,
            'SHOW_ROW_ACTIONS_MENU' => true,
            'SHOW_GRID_SETTINGS_MENU' => true,
            'SHOW_NAVIGATION_PANEL' => true,
            'SHOW_PAGINATION' => true,
            'SHOW_SELECTED_COUNTER' => false,
            'SHOW_TOTAL_COUNTER' => true,
            'SHOW_PAGESIZE' => true,
            'SHOW_ACTION_PANEL' => true,

            'ENABLE_COLLAPSIBLE_ROWS' => true,
            'ALLOW_SAVE_ROWS_STATE' => true,

            'SHOW_MORE_BUTTON' => false,
            'CURRENT_PAGE' => '',
            'DEFAULT_PAGE_SIZE' => 20,
            'PAGE_SIZES' => [
                ['NAME' => 1, 'VALUE' => 1],
                ['NAME' => 5, 'VALUE' => 5],
                ['NAME' => 10, 'VALUE' => 10],
                ['NAME' => 20, 'VALUE' => 20],
                ['NAME' => 50, 'VALUE' => 50],
            ],
        ],
    );
};

$addDoctorButton = new \Bitrix\UI\Buttons\AddButton(
    [
        "click" => new \Bitrix\UI\Buttons\JsCode(
            "BX.SidePanel.Instance.open('?TYPE=DOCTOR');"
        ),
        "text" => "Добавить врача"
    ]
);

$addProcedureButton = new \Bitrix\UI\Buttons\AddButton(
    [
        "click" => new \Bitrix\UI\Buttons\JsCode(
            "BX.SidePanel.Instance.open('?TYPE=PROCEDURES');"
        ),
        "text" => "Добавить процедуру"
    ]
);

\Bitrix\UI\Toolbar\Facade\Toolbar::addButton($addDoctorButton);
\Bitrix\UI\Toolbar\Facade\Toolbar::addButton($addProcedureButton);


//\Bitrix\Main\Diag\Debug::dump($arParams);
//\Bitrix\Main\Diag\Debug::dump($arResult);