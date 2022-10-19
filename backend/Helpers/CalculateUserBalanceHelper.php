<?php
require_once("../DataAccessLayer/CoinsDAL.php");
require_once("../DataAccessLayer/OrdersDAL.php");
require_once("../DataAccessLayer/UsersDAL.php");
require_once("../DataAccessLayer/ProductsDAL.php");

function CalculateUserBalanceHelper($userId)
{
    $coins = CoinsDAL::TryGetAllCoinsForUser($userId);
    $orders = OrdersDAL::TryGetAllOrdersForUser($userId);
    $products = ProductsDAL::GetAllProducts();

    $earned_coins = 0;
    foreach ($coins as $coin) {
        $earned_coins += $coin->price;
    }

    $spended_coins = 0;
    foreach ($orders as $order) {
        $ordered_product = null;
        foreach ($products as $product) {
            if ($product->id == $order->product_id) {
                $ordered_product = $product;
                break;
            }
        }
        if ($ordered_product != null)
            $spended_coins += $ordered_product->price;
        else error_log("Order without proper product occured");
    }

    $balance = $earned_coins - $spended_coins;

    return $balance;
}
