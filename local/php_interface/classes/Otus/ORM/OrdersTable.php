<?php
namespace Otus\ORM;

use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\Type\DateTime;

/**
 * Class OrdersTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> order_date datetime optional default current datetime
 * <li> total double mandatory
 * </ul>
 *
 * @package Bitrix\Orders
 **/

class OrdersTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'otus_orders';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'id',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => 'ID',
                ]
            ),
            new DatetimeField(
                'order_date',
                [
                    'default' => function () {
                        return new DateTime();
                    },
                    'title' => 'Дата создания',
                ]
            ),
            new FloatField(
                'total',
                [
                    'required' => true,
                    'title' => 'Итог',
                ]
            ),
            new IntegerField('GOODS_ID'),
            new Reference(
                'GOODS',
                \Bitrix\Iblock\Elements\ElementGoodsTable::class,
                Join::on('this.GOODS_ID', 'ref.ID')
            ),
            new IntegerField('CUSTOMERS_ID'),
            new Reference(
                'CUSTOMERS',
                \Bitrix\Iblock\Elements\ElementCustomersTable::class,
                Join::on('this.CUSTOMERS_ID', 'ref.ID')
            )
        ];
    }
}