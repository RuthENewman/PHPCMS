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
        $result = self::findQuery("SELECT * FROM users WHERE id = $userId LIMIT 1");
        return !empty($result) ? array_shift($result) : false;
    }

    public static function findQuery($sql)
    {
        global $database;
        $resultSet = $database->query($sql);
        $object = [];
        while ($row = mysqli_fetch_array($resultSet)) {
            $object[] = self::instantiation($row); 
        }
        return $object;
    }

    public static function verifyUser()
    {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);
        $sql = "SELECT * FROM users WHERE
                email = '{$email}' AND 
                password = '{$password}' LIMIT 1";
        $resultArray = self::findQuery($sql);
        return !empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function instantiation($record)
    {
        $row = new self();
        foreach ($record as $attribute => $value) {
            if($row->hasAttribute($attribute)) {
                $row->$attribute = $value;
            }
        }
        return $row;
    }

    private function hasAttribute($attribute)
    {
       $columnsForRow = get_object_vars($this);
       return array_key_exists($attribute, $columnsForRow);
    }
}
