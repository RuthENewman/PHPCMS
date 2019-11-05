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


}
