<?php

    require_once 'app/libraries/Database.php';
    require_once 'app/config/config.php';
    define('DB_INIT', 0);

    $db = new Database(DB_INIT);
    $db->query(
        'CREATE DATABASE IF NOT EXISTS `camagru`;
         USE camagru;
         CREATE TABLE user (id INT PRIMARY KEY AUTO_INCREMENT,
         username VARCHAR(255) NOT NULL,
         email VARCHAR(255) NOT NULL,
         password VARCHAR(255) NOT NULL,
         CONSTRAINT userconst UNIQUE(email)
         );
         CREATE INDEX userindex  ON user (id, email);
        ');
    if ($db->execute())
         echo 'Database Scheme is successfully created !!';
    unset($db); // close PDO connection
?>