<?php 

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

define('DS') ? null : define('SITE_ROOT', DS . 'Applications' . DS . 'XAMPP' . DS . 'xamppfiles' . DS . 'htdocs' . DS . 'my-gallery-app');

define('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');

require_once("functions.php");
require_once("new_config.php");
require_once("database.php");
require_once("model.php");
require_once("user.php");
require_once("photo.php");
require_once("session.php");

?>