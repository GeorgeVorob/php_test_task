<?php
require_once("../Services/DbService.php");
class OrdersDAL
{
    public static function TryGetAllOrdersForUser($userId)
    {
        $conn = DbService::connectToDb();
        $result = [];
        try {
            $query =
                $conn->prepare("SELECT product_id, user_id FROM orders_users WHERE user_id = ?;");
            $query->bind_param("i", $userId);

            $query->execute();
            $rows = $query->get_result();

            while ($row = $rows->fetch_object()) {
                array_push($result, $row);
            }
        } finally {
            $conn->close();
        }

        return $result;
    }

    public static function AddNewPurchase($userId, $productId)
    {
        $conn = DbService::connectToDb();
        try {
            $query =
                $conn->prepare("INSERT INTO orders_users (product_id, user_id) VALUES ( ? , ? );");
            $query->bind_param("ii", $productId, $userId);

            $query->execute();
        } finally {
            $conn->close();
        }
    }
}
