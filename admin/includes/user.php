<?php 

class User extends Model 
{
    protected static $db_table = "users";
    protected static $db_table_fields = ['email', 'password', 'first_name', 'last_name', 'userImage'];
    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $userImage;
    public $uploadDirectory = "images";
    public $imagePlaceholder = "http://placehold.it/100x100&text=image";

    public function setFile($file)
    {
        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "No file was uploaded here";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->uploadErrors[$file['error']];
            return false;
        } else {
            $this->userImage = basename($file['name']);
            $this->tmpPath = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function saveUserAndImage()
    {
        if($this->id) {
            $this->update();
        } else {
            if(!empty($this->errors)) {
                return false;
            }
            if(empty($this->userImage) || empty($this->tmpPath)) {
                $this->errors[] = "The file was not available";
                return false;
            }
            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->uploadDirectory . DS . $this->userImage;
            if(file_exists($targetPath)) {
                $this->errors[] = "The file {$this->userImage} already exists.";
                return false;
            }
            if(move_uploaded_file($this->tmpPath, $targetPath)) {
                if($this->create()) {
                    unset($this->tmpPath);
                    return true;
                }
            } else {
                $this->errors[] = "Please check your permissions";
            }
        }
    }

    public function imagePathAndPlaceholder()
    {
        return empty($this->userImage) ? $this->imagePlaceholder : $this->uploadDirectory . DS . $this->userImage;
    }

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

}
