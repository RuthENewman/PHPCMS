<?php 

class User {

    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;

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

    public static function instantiation($foundUser)
    {
        $user = new self();
        $user->id = $foundUser['id'];
        $user->email = $foundUser['email'];
        $user->password = $foundUser['password'];
        $user->first_name = $foundUser['first_name'];
        $user->last_name = $foundUser['last_name'];
        return $user;
    }

}
