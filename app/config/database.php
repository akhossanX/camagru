<?php
    $DB_HOST = getenv('DB_HOST') || 'localhost';
    $DB_NAME = getenv('DB_NAME') || 'camagru';
    $DB_USER = getenv('DB_USER') || 'root';
    $DB_PASSWORD = getenv('DB_PASSWORD') || "don't tell anyone our Secr3t!";
    $PORT = getenv('PORT') || '8080';

    // Database parameters
    define ('DB_HOST', $DB_HOST);
    define ('DB_NAME', $DB_NAME);
    define ('DB_USER', $DB_USER);
    define ('DB_PASSWD', $DB_PASSWORD);
    define ('PORT', $PORT);
    define ('ADDRESS', 'http://' . $DB_HOST);

    // Project Root Directory
    define('ROOT', dirname(dirname(dirname(__FILE__))));

	// App Root
    define('APPROOT', dirname(dirname(__FILE__)));

    // URL Root
    define('URLROOT', ADDRESS . ':' . PORT);
    // Site name
    define('SITENAME', 'Camagru');
