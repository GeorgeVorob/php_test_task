<?php
require_once("../DataAccessLayer/UsersDAL.php");
require_once("../DataAccessLayer/OrdersDAL.php");
require_once("../Helpers/CalculateUserBalanceHelper.php");

$recievedLogin = $_GET['login'];
$user = UsersDAL::TryGetUserByLogin($recievedLogin);

if ($user->id == null) {
    http_response_code(400);
    die();
}

$purchased_products_ids = [];
$orders = OrdersDAL::TryGetAllOrdersForUser($user->id);
foreach ($orders as $order) {
    array_push($purchased_products_ids, $order->product_id);
}

$balance = CalculateUserBalanceHelper($user->id);

$response = new stdClass();
$response->user = $user;
$response->user->balance = $balance;
$response->user->purchasedProducts = $purchased_products_ids;
echo json_encode($response);
