<?php
function __autoload($class_name)
{
    $file = "./Tools/" . $class_name . "_class.php";
    if (file_exists($file)) {
        include_once $file;
    }
}

$config = array(
    'host' => 'localhost',
    'port' => '3306',
    'user' => 'root',
    'password' => 'bs2691000',
    'database' => 'php38',
    'charset' => 'utf8'
);
