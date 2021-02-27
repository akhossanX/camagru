<?php
    // Load configuration file
    require_once 'config/config.php';
    
    // Autoload core libraries
    spl_autoload_register(function($className) {
        $file = APPROOT . '/libraries/' . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            $file = APPROOT  . '/models/' . $className . '.php';
            require_once $file;
        }
    });

?>