<?php


    class User {

        private $db;
        private $name;
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

        public function save($user)
        {
            $query = 'INSERT INTO user (
                    username, email, password
                    ) VALUES (
                        :username, :email, :password
                    )';
            $this->db->query($query);
            $this->db->bind(':username', $user->username, null);
            $this->db->bind(':email', $user->email, null);
            $this->db->bind(':password', $user->password, null);
            $this->db->execute();
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