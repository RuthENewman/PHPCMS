<?php 

class User extends Model 
{
    protected static $db_table = "users";
    protected static $db_table_fields = ['email', 'password', 'first_name', 'last_name'];
    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;

    public static function verifyUser($email, $password)
    {
        global $database;

        $email = $database->escapeString($email);
        $password = $database->escapeString($password);
        $sql = "SELECT * FROM " . self::$db_table . " WHERE
                email = '{$email}' AND 
                password = '{$password}' LIMIT 1";
        $resultArray = self::findQuery($sql);
        return !empty($resultArray) ? array_shift($resultArray) : false;
    }

  

}
