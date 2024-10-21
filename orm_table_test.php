<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

// Получаем заказы с информацией о клиентах и товарах
$orders = \Otus\ORM\OrdersTable::query()
    ->setSelect(['*', 'CUSTOMERS', 'CUSTOMERS.EMAIL', 'CUSTOMERS.LAST_NAME', 'GOODS', 'GOODS.COST'])
    ->fetchCollection();

foreach ($orders as $order) {
    $customer = $order->getCustomers();
    $goods = $order->getGoods();

    $output = <<<HTML
<div>
    <strong>ID заказа:</strong> {$order->getId()}<br>
    <strong>Дата заказа:</strong> {$order->getOrderDate()}<br>
    <strong>Сумма заказа:</strong> {$order->getTotal()}<br>
HTML;

    if ($customer) {
        $output .= <<<HTML
    <strong>ID клиента:</strong> {$customer->getId()}<br>
    <strong>Имя клиента:</strong> {$customer->getName()}<br>
    <strong>Email клиента:</strong> {$customer->getEmail()->getValue()}<br>
    <strong>Фамилия клиента:</strong> {$customer->getLastName()->getValue()}<br>
HTML;
    } else {
        $output .= "Клиент не найден.<br>";
    }

    if ($goods) {
        $output .= <<<HTML
    <strong>ID товара:</strong> {$goods->getId()}<br>
    <strong>Название товара:</strong> {$goods->getName()}<br>
    <strong>Цена товара:</strong> {$goods->getCost()->getValue()}<br>
HTML;
    } else {
        $output .= "Товар не найден.<br>";
    }

    $output .= "</div><br>";

    echo $output;
}
