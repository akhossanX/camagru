<?php
    // Database parameters
    define ('DB_HOST', '127.0.0.1');
    define ('DB_NAME', 'camagru');
    define ('DB_USER', 'root');
    define ('DB_PASSWD', '');
    define ('PORT', '8080');
    define ('ADDRESS', 'http://localhost');

    // Project Root Directory
    define('ROOT', dirname(dirname(dirname(__FILE__))));

	// App Root
    define('APPROOT', dirname(dirname(__FILE__)));

    // URL Root
    define('URLROOT', ADDRESS . ':' . PORT);
    // Site name
    define('SITENAME', 'Camagru');
