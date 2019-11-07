<?php

class Photo extends Model
{
    protected static $db_table = "photos";
    protected static $db_table_fields = ['title', 'description', 'caption', 'filename', 'type', 'size', 'alternateText'];

    public $id;
    public $title;
    public $description;
    public $caption;
    public $filename;
    public $type;
    public $size;
    public $alternateText;

    public $tmpPath;
    public $uploadDirectory = "images";
    public $errors = [];
    public $uploadErrors = [
        UPLOAD_ERR_OK => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize set",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the max_file_size set.",
        UPLOAD_ERR_PARTIAL => "The file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
    ];

    // Passing $_FILES['uploadedFile'] as an argument

    public function setFile($file)
    {
        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "No file was uploaded here";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->uploadErrors[$file['error']];
            return false;
        } else {
            $this->filename = basename($file['name']);
            $this->tmpPath = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function picturePath()
    {
        return $this->uploadDirectory . DS . $this->filename;
    }

    public function save()
    {
        if($this->id) {
            $this->update();
        } else {
            if(!empty($this->errors)) {
                return false;
            }
            if(empty($this->filename) || empty($this->tmpPath)) {
                $this->errors[] = "The file was not available";
                return false;
            }
            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->uploadDirectory . DS . $this->filename;
            if(file_exists($targetPath)) {
                $this->errors[] = "The file {$this->filename} already exists.";
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

    public function deletePhoto()
    {
        if ($this->delete()) {
            $targetPath = SITE_ROOT . DS . "admin" . DS . $this->picturePath();
            return unlink($targetPath) ? true : false;
        } else {
            return false;
        }
    }



}
