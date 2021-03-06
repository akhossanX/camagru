<?php

    class BaseModel {

        protected $db;
        protected $stmt;

        public function __construct() {
            $this->db = Database::connect();
        }
        // Prepare statement
        public function query($sql) {
            $this->stmt = $this->db->prepare($sql);
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
            try {
                return $this->stmt->execute();
            } catch (PDOException $e) {
                echo "ERROR: {$e->getMessage()}";
                return false;
            }
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
            $this->execute();
            return $this->stmt->rowCount();
        }
    }

?>