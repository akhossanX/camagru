<?php


    class User {

        private $db;
        private $username;
        private $email;
        private $password;


        public function __construct () {
            $this->db = new Database();
        }

        
        public function findUserByemail($email) {
            $query = 'SELECT * FROM user WHERE email like :email';
            $this->db->query($query);
            $this->db->bind(':email', $email, null);
            return $this->db->single();
        }
        /*
        **  Mapps user objects to user record in user table
        **  We assume the password is already hashed
        ** $user = new User();
        ** $user.save
        */
        
        public function save()
        {
            $query = 'USE camagru; INSERT INTO user (
                    username, email, password
                    ) VALUES (
                        :username, :email, :password
                    )';
            $this->db->query($query);
            $this->db->bind(':username', $this->username, null);
            $this->db->bind(':email', $this->email, null);
            $this->db->bind(':password', hash('whirlpool', $this->password), null);
            $this->db->execute();
        }
        
        public function register() {
            $this->password = hash('whirlpool', $this->password);
            $sql = 'INSERT INTO user (username, email, password) VALUES (:username, :email, :password)';
            $this->db->query($sql);
            $this->db->bind(':username', $this->username, null);
            $this->db->bind(':email', $this->email, null);
            $this->db->bind(':password', $this->password, null);
            $this->db->execute();
        }

        /*
        **  Getters and setters
        */

        public function setUserName($username) {
            $this->username = $username;
        }
        public function getUserName() {
            return $this->username;
        }
        public function setEmail($email) {
            $this->email = $email;
        }
        public function getEmail() {
            return $this->email;
        }
        public function setPassword($password) {
            $this->password = $password;
        }
        public function getPassword() {
            return $this->password;
        }
    }