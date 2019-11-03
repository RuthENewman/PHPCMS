<?php 

function classAutoLoader($class)
{
    $class = strtolower($class);
    $path = "includes/{$class}.php";

    if(is_file($path) && !class_exists($class)) {
        include $path;
    } else {
        die("The file {$class}.php could not be found");
    }

}

function redirect($location)
{
    header("Location: {$location}");
}

spl_autoload_register('classAutoLoader');