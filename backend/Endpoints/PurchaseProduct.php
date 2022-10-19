<?php
//TODO: сделать POST запросом.

require_once("../DataAccessLayer/UsersDAL.php");
require_once("../DataAccessLayer/OrdersDAL.php");
require_once("../DataAccessLayer/ProductsDAL.php");
require_once("../Helpers/CalculateUserBalanceHelper.php");

$recievedLogin = $_GET['login'];
$recievedProductId = $_GET['id'];

$user = UsersDAL::TryGetUserByLogin($recievedLogin);
// Нет такого логина
if ($user->id == null) {
    http_response_code(400);
    die();
}

$balance = CalculateUserBalanceHelper($user->id);

//TODO: написать метод для выбора конкретного продукта по id.
$products = ProductsDAL::GetAllProducts();
$product = null;

//заменить на array_search?
foreach ($products as $possible_product) {
    if ($possible_product->id == $recievedProductId) {
        $product = $possible_product;
        break;
    }
}
// Нет такого продукта
if ($product == null) {
    http_response_code(400);
    die();
}
// Недостаточно средств
if ($product->price > $balance) {
    http_response_code(400);
    die();
}

$orders = OrdersDAL::TryGetAllOrdersForUser($user->id);
foreach ($orders as $order) {
    // Уже была такая покупка.
    if ($order->product_id == $product->id && $order->user_id == $user->id) {
        http_response_code(400);
        die();
        break;
    }
}

OrdersDAL::AddNewPurchase($user->id, $product->id);

echo 4;
