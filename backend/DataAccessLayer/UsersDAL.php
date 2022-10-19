<?php
require_once("../Services/DbService.php");
class UsersDAL
{
    public static function TryGetUserByLogin($userLogin)
    {
        $conn = DbService::connectToDb();
        $result = new stdClass();

        try {
            $query =
                $conn->prepare("SELECT id, name, login FROM users WHERE login = ?;");
            $query->bind_param("s", $userLogin);

            $query->execute();
            $query->store_result();
            $query->bind_result(
                $result->id,
                $result->name,
                $result->login
            );

            $query->fetch();
        } finally {
            $conn->close();
        }

        return $result;
    }
}
