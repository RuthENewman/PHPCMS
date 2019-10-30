<?php 

class User {


    public static function findAll()
    {
        return self::findQuery("SELECT * FROM users");
    }

    public static function find($userId)
    {   
        $user = self::findQuery("SELECT * FROM users WHERE id = $userId LIMIT 1");
        return mysqli_fetch_array($user);
    }

    public static function findQuery($sql)
    {
        global $database;
        $resultSet = $database->query($sql);
        return $resultSet;
    }

}
