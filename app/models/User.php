<?php

    // require_once APPROOT . '/libraries/Database.php';

    class User {

        private $db;

        public function __construct () {
            $this->db = new Database();
        }

        public function findUserByemail($email) {
            $query = 'SELECT * FROM user WHERE email like :email';
            $this->db->query($query);
            $this->db->bind(':email', $email, null);
            return $this->db->single();
        }

        public function register($name, $email, $password) {
            $password = hash('whirlpool', $password);
            $sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';
            $this->db->query($sql);
            $this->db->bind(':name', $name, null);
            $this->db->bind(':email', $email, null);
            $this->db->bind(':password', $password, null);
            $this->db->execute();
        }
    }