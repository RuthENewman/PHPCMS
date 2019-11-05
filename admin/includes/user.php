<?php 

class User {

    protected static $db_table = "users";
    protected static $db_table_fields = ['email', 'password', 'first_name', 'last_name'];
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

    protected function properties()
    {
        $properties = [];
        foreach (self::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function cleanProperties()
    {
        global $database;
        $cleanProperties = [];
        foreach($this->properties() as $key => $value) {
            $cleanProperties[$key] = $database->escapeString($value);
        }
        return $cleanProperties;
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create()
    {
        global $database;
        $properties = $this->cleanProperties();

        $sql = "INSERT INTO " . self::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";
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
        $properties = $this->cleanProperties();
        $properties_pairs = [];
        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE  " . self::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id=" . $database->escapeString($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete()
    {
        global $database;
        $sql = "DELETE FROM  " . self::$db_table . " ";
        $sql .= "WHERE id=" . $database->escapeString($this->id);
        $sql .= "  LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

}
