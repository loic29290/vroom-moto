<?php

// Autoloader
spl_autoload_register(function ($class_name) {
    // classes
    $file_name = "class/" . strtolower($class_name) . ".php";

    if (file_exists($file_name)) {
        require_once $file_name;
    }


    // controllers
    $file_name = "controller/" . lcfirst($class_name) . ".php";
    if (file_exists($file_name)) {
        require_once $file_name;
    }
});
