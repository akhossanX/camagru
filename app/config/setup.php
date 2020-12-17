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
            active BOOLEAN NOT NULL DEFAULT FALSE
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
    $query = 'CREATE VIEW public_gallery_images AS SELECT u.username,i.data FROM image as i, user as u WHERE i.user_id=u.id';
    if ($db->prepare($query)->execute())
        echo 'Public gallery images view created successfully !!';

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