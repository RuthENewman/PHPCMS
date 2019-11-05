<?php

class Photo extends Model
{
    protected static $db_table = "photos";
    protected static $db_table_fields = ['id', 'title', 'description', 'filename', 'type', 'size'];

    public $photo_id;
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;

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





    

}
