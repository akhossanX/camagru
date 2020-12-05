<?php

    /*
    **  Database Class
    **  Connects to database
    */

    class Database 
    {

        static $pdo = null;
        private $error;

        public static function connect($flag = 1) {
            $flag === 0 ? $dbname = '' : $dbname = ';dbname=' . DB_NAME;
            $dsn = 'mysql:host=' . DB_HOST . $dbname;
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            try {
                self::$pdo = new PDO(
                    $dsn,
                    DB_USER,
                    DB_PASSWD,
                    $options
                );
            } catch (PDOException $e) {
                self::$error = $e->getMessage();
                echo "Connexion to Database failed:" . PHP_EOL;
                die(self::$error);
            }
            return self::$pdo;
        }
    }

