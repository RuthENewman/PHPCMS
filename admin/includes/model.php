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

}