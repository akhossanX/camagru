<?php

    require_once 'app/libraries/Database.php';
    require_once 'app/config/config.php';
    define('DB_INIT', 0);

    function try_execute($db, $query, $success_msg) {
        try {
            $db->prepare($query)->execute();
            echo $success_msg . PHP_EOL;
        } catch (PDOException $e) {
            die ($e->getMessage());
        }
    }

    $db = Database::connect(DB_INIT);
    $query = "
        DROP DATABASE IF EXISTS camagru;
        CREATE DATABASE camagru;
        USE camagru;
    ";
    try_execute($db, $query, 'Database Scheme has been successfully created !!');
    $query = "
        CREATE TABLE user (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `username` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `hash` VARCHAR(255) NOT NULL,
            `active` BOOLEAN NOT NULL DEFAULT FALSE,
            `notify` BOOLEAN NOT NULL DEFAULT TRUE
        );
        CREATE INDEX userindex ON user (id, email);
    ";
    try_execute($db, $query, 'User table created!...');
    $query = "
        CREATE TABLE image (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `data` LONGBLOB NOT NULL,
            `user_id` INT NOT NULL,
            `creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `likes` INT NOT NULL DEFAULT 0,
            FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
        );
    ";
    try_execute($db, $query, 'Image table created!...');
    $query = "
        CREATE TABLE comment (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `text` VARCHAR(720) NOT NULL,
            `image_id` INT NOT NULL,
            FOREIGN KEY (image_id) REFERENCES image(id)
        );
    ";
    try_execute($db, $query, 'Comment table created!...');

    $query = "
        CREATE VIEW public_gallery_images AS 
        SELECT u.username,i.data FROM image AS i, user AS u WHERE i.user_id=u.id;
    ";
    try_execute($db, $query, 'Public gallery images view created!...');

    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789_";
    if (isset($argv[1]) && $argv[1] == '-p') {
        echo 'Populating database with random data...';
        $passwd = hash('whirlpool', '12345678a');
        for ($i = 1; $i <= 100; $i++){
            $username = substr($str, rand(0, strlen($str) - 1), rand(2, 8));
            $query = 'insert into user (username, email, password, hash) values ("'
            . $username . '", "'
            . substr($str, rand(0, strlen($str) - 1), rand(2, 8)) . '@' . substr($str, rand(0, strlen($str) - 1), rand(2, 8))
            . '.com"' . ', "' . $passwd . '", ' . '"' . hash('whirlpool' , $username . SODIUM_CRYPTO_PWHASH_SALTBYTES) . '");';
            $db->prepare($query)->execute();
        }

        for ($i = 1; $i <= 100; $i++) {
            $url = 'https://picsum.photos/id/' . rand(1, 100) . '/200/300';
            $rand = base64_encode(file_get_contents($url));
            $query = 'insert into image (name, data, user_id) values (\'';
            $query .= substr($str, rand(0, strlen($str) - 1), rand(2, 8)) . '\', \'';
            $query .= $rand . '\', ';
            $query .= $i . ');';
            var_dump($query);
            $db->prepare($query)->execute();
        }
    }
    echo 'done.';
    unset($db); // close PDO connection
?>