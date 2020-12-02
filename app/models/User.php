<?php


    class User {

        private $db;
        private $username;
        private $email;
        private $password;
        private $hash;
        private $secretkey;


        public function __construct () {
            $this->db = new Database();
            $this->secretkey = random_bytes(10);
        }

        public function findUserByHash($hash) {
            $query = 'SELECT * from user WHERE hash like :hash';
            $this->db->query($query);
            $this->db->bind(':hash', $hash);
            return $this->db->single();
        }
        
        public function findUserByemail() {
            $query = 'SELECT * FROM user WHERE email like :email';
            $this->db->query($query);
            $this->db->bind(':email', $this->email);
            return $this->db->single();
        }

        public function updateRecord($targetId, $column, $value) {
            $query = 'UPDATE user SET ' . $column . '=:value WHERE id like :id';
            $this->db->query($query);
            $this->db->bind(':value', $value);
            $this->db->bind(':id', $targetId);
            $this->db->execute();
        }

        /*
        **  Maps user objects to user record in user table
        **  We assume the password is already hashed
        ** $user = new User();
        ** $user.save
        */
        
        public function save()
        {
            $query = 'USE camagru; INSERT INTO user (
                    username, email, password, hash
                    ) VALUES (
                        :username, :email, :password, :hash
                    )';
            $this->db->query($query);
            $this->db->bind(':username', $this->username, null);
            $this->db->bind(':email', $this->email, null);
            $this->db->bind(':password', hash('whirlpool', $this->password), null);
            $this->db->bind(':hash', hash('whirlpool', $this->username . $this->secretkey), null);
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