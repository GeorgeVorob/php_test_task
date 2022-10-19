<?php
class DbService
{
    public static function connectToDb()
    {
        //TODO: Вынесли во внешний конфиг.
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "php_test_task";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public static function CallQuery($query)
    {
        $conn = DbService::connectToDb();
        $response = $conn->query($query);
        $conn->close();

        return $response;
    }
}
