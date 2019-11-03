<?php 

class Session
{
    private $signedIn = false;
    public $userId;

    function __construct()
    {
        session_start();
        $this->checkLogin();
    }

    private function checkLogin()
    {
        if(isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
            $this->signedIn = true;
        } else {
            unset($this->userId);
            $this->signedIn = false;
        }
    }

}

$session = new Session();