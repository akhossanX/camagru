<?php

    require_once 'app/libraries/Database.php';
    require_once 'app/config/config.php';

    $db = new Database();
    $db->query(
        'CREATE DATABASE IF NOT EXISTS `camagru`;
         USE camagru;
         CREATE TABLE user (id INT PRIMARY KEY AUTO_INCREMENT,
         username VARCHAR(255) NOT NULL,
         email VARCHAR(255) NOT NULL,
         password VARCHAR(255) NOT NULL,
         CONSTRAINT userconst UNIQUE(id, email)
         );
         CREATE INDEX userindex  ON user (id, email);
        ');
    var_dump($db->execute());
?>