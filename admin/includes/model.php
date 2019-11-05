<?php 

class Model
{
    public static function findAll()
    {
        return static::findQuery("SELECT * FROM " . static::$db_table . " ");
    }

    public static function find($id)
    {   
        $result = static::findQuery("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
        return !empty($result) ? array_shift($result) : false;
    }

    public static function findQuery($sql)
    {
        global $database;
        $resultSet = $database->query($sql);
        $object = [];
        while ($row = mysqli_fetch_array($resultSet)) {
            $object[] = static::instantiation($row); 
        }
        return $object;
    }

    public static function instantiation($record)
    {
        $calledClass = get_called_class();
        $row = new $calledClass;
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
        foreach (static::$db_table_fields as $db_field) {
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

        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
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
        $sql = "UPDATE  " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id=" . $database->escapeString($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete()
    {
        global $database;
        $sql = "DELETE FROM  " . static::$db_table . " ";
        $sql .= "WHERE id=" . $database->escapeString($this->id);
        $sql .= "  LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

}
