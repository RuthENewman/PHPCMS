<?php 

class User {


public function findAllUsers()
{
    global $database;
    $resultSet = $database->query("SELECT * FROM users");
    return $resultSet;
}





}
