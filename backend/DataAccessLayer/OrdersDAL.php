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
}
