<?php
require_once("../Services/DbService.php");
class CoinsDAL
{
    public static function TryGetAllCoinsForUser($userId)
    {
        $conn = DbService::connectToDb();
        $result = [];
        try {
            $query =
                $conn->prepare("SELECT id, price, action FROM coins WHERE user_id = ?;");
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
