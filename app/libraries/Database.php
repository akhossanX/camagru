<?php

    /*
    **  Database Class
    **  Connects to database
    **  Creates prepared statements
    **  Binds values
    **  Returns result sets
    */

    class Database 
    {
        public $dbname = DB_NAME;
        public $host = DB_HOST;
        public $user = DB_USER;
        public $passwd = DB_PASSWD;

        private $pdo;
        private $stmt;
        private $error;

        public function __construct($flag = 1) {
            $flag === 0 ? $dbname = '' : $dbname = ';dbname=' . $this->dbname;
            $dsn = 'mysql:host=' . $this->host . $dbname;
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            try {
                $this->pdo = new PDO(
                    $dsn,
                    $this->user,
                    $this->passwd,
                    $options
                );
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo "Connexion to Database failed:" . PHP_EOL;
                die($this->error);
            }
        }
        // Prepare statement
        public function query($sql) {
            $this->stmt = $this->pdo->prepare($sql);
        }
        // Bind values
        public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                if (is_bool($value))
                    $type = PDO::PARAM_BOOL;
                else if (is_null($value))
                    $type = PDO::PARAM_NULL;
                else if (is_int($value))
                    $type = PDO::PARAM_INT;
                else
                    $type = PDO::PARAM_STR;
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        public function execute() {
            return $this->stmt->execute();
        }

        public function resultset() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        // Get a single record;
        public function single() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        public function rowCount() {
            return $this->stmt->rowCount();
        }
    }
