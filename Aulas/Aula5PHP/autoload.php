<?php
require_once 'autoload.php';
session_start();

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
?>
