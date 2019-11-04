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

    public static function verifyUser($email, $password)
    {
        global $database;

        $email = $database->escapeString($email);
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

    public function createUser()
    {
        global $database;
        $sql = "INSERT INTO users (email, password, first_name, last_name)";
        $sql .= "VALUES ('";
        $sql .= $database->escapeString($this->email) . "', '";
        $sql .= $database->escapeString($this->password) . "', '";
        $sql .= $database->escapeString($this->first_name) . "', '";
        $sql .= $database->escapeString($this->last_name) . "')";
        if ($database->query($sql)) {
            $this->id = $database->insertID();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        global $database;
        $sql = "UPDATE users SET email= '" . $database->escapeString($this->email) . "', 
        password= '" . $database->escapeString($this->password) . "', 
        first_name= '" . $database->escapeString($this->first_name) . "', 
        last_name= '" . $database->escapeString($this->last_name) . "' 
        WHERE id=" . $database->escapeString($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete()
    {
        global $database;
        $sql = "DELETE FROM users ";
        $sql .= "WHERE id=" . $database->escapeString($this->id);
        $sql .= "  LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

}
