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
