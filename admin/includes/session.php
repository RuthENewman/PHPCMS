<?php 

class Session
{
    private $signedIn;
    public $userId;

    function __construct()
    {
        session_start();
    }


}

$session = new Session();