<?php
class DbService
{
    public static function connectToDb()
    {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "php_test_task";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
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
