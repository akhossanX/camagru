<?php

    require_once 'app/libraries/Database.php';
    require_once 'app/config/config.php';
    define('DB_INIT', 0);

    $db = Database::connect(DB_INIT);
    $query =
        "
        DROP DATABASE IF EXISTS camagru;
        CREATE DATABASE camagru;
        USE camagru;
        CREATE TABLE user (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            hash VARCHAR(255) NOT NULL,
            active BOOLEAN NOT NULL DEFAULT FALSE,
            CONSTRAINT emailconst UNIQUE(email),
            CONSTRAINT nameconst UNIQUE(username)
        );
        CREATE INDEX userindex ON user (id, email);
        CREATE TABLE image (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            data LONGBLOB NOT NULL,
            user_id INT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES user(id)
        );
        ";
    if ($db->prepare($query)->execute())
         echo 'Database Scheme has been successfully created !!';
    unset($db); // close PDO connection
?>