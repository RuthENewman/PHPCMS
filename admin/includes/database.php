<?php 

require_once("new_config.php");

class Database {

    public $connection;

    public function __construct() {
        $this->openDBConnection();
    }

    public function openDBConnection() 
    {
        $this->connection = mysqli_connect(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if (mysqli_connect_errno()) {
            die("Database connection failed " . mysqli_error());
        }
    }

    public function query($sql) 
    {
        return mysqli_query($this->connection, $sql);
    }

    private function confirmQuery($result) 
    {
        if(!$result) {
            exit("Query failed");
        }
    }

    public function escapeString($string) 
    {
        return mysqli_real_escape_string($this->connection, $string);
    }


}

$database = new Database();

?>