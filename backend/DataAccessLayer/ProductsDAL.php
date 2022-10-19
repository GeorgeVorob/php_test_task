<?php
require_once("../Services/DbService.php");
class ProductsDAL
{
    public static function GetAllProducts()
    {
        $conn = DbService::connectToDb();
        $result = [];
        try {
            $query =
                $conn->prepare("SELECT id, description, price FROM products");

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
