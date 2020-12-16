<?php
    require_once 'BaseModel.php';

    class User extends BaseModel {

        private $username;
        private $email;
        private $password;
        private $hash;
        private $secretkey;


        public function __construct () {
            parent::__construct();
            $this->secretkey = random_bytes(10);
        }

        public function findUserByHash($hash) {
            $query = 'SELECT * from user WHERE hash like :hash';
            $this->query($query);
            $this->bind(':hash', $hash);
            return $this->single();
        }
        
        public function findUserByemail($email) {
            $query = 'SELECT * FROM user WHERE email like :email';
            $this->query($query);
            $this->bind(':email', $email);
            return $this->single();
        }

        public function findUserByName($name) {
            $query = 'SELECT * FROM user WHERE username like :name';
            $this->query($query);
            $this->bind(':name', $name);
            return $this->single();
        }

        public function findUserById($userid) {
            $query = 'SELECT * FROM user WHERE id like :userid';
            $this->query($query);
            $this->bind(':userid', $userid);
            return $this->single();
        }

        public function updateColumn($targetId, $column, $value) {
            $query = 'UPDATE user SET ' . $column . '=:value WHERE id like :id';
            $this->query($query);
            $this->bind(':value', $value);
            $this->bind(':id', $targetId);
            $this->execute();
        }
        /*
        **  Update an entire row identified by its id
        */
        public function updateRow($id) {
            $pwd = hash('whirlpool', $this->password);
            $query = 'UPDATE user SET username=:username, email=:email, password=:password where id like :id;';
            $this->query($query);
            $this->bind(':username', $this->username);
            $this->bind(':email', $this->email);
            $this->bind(':password', $pwd);
            $this->bind(':id', $id);
            $this->execute();
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
            $this->query($query);
            $this->bind(':username', $this->username, null);
            $this->bind(':email', $this->email, null);
            $this->bind(':password', hash('whirlpool', $this->password), null);
            $this->bind(':hash', hash('whirlpool', $this->username . $this->secretkey), null);
            $this->execute();
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