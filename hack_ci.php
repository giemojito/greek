<?php
// Add this code to the bottom of system/application/config/config.php:

function __autoload($class) {
    if (file_exists(APPPATH."models/".strtolower($class).EXT)) {
        include_once(APPPATH."models/".strtolower($class).EXT);
    }
}

// or

function __autoload($class) {
    if (file_exists(APPPATH."models/".strtolower($class).EXT)) {
        include_once(APPPATH."models/".strtolower($class).EXT);
    } else if (file_exists(APPPATH."controllers/".strtolower($class).EXT)) {
        include_once(APPPATH."controllers/".strtolower($class).EXT);
    }
}

function __autoload($classname) {
    if (strpos($classname, 'CI_') !== 0) {
        $file = APPATH . 'libraries/' . $classname . EXT;
        if (file_exists($file) && is_file($file)) {
            @include_once($file);
        }
    }
}



// Running CodeIgniter from the Command Line
// Create a "cli.php" file at the root of your CodeIgniter folder:
if (isset($_SERVER['REMOTE_ADDR'])) {
    die('Command Line Only!');
}
 
set_time_limit(0);
 
$_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'] = $argv[1];
 
require dirname(__FILE__) . '/index.php';


// If you are on a Linux environment and want to make this script self executable, you can add this as the first line in cli.php:
#!/usr/bin/php

// If you want a specific controller to be command line only, you can block web calls at the controller constructor:
class Hello extends Controller {
 
    function __construct() {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            die('Command Line Only!');
        }
        parent::Controller();
    }
 
    // ...
 
}