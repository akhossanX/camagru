<?php
    class Users extends Controller
    {
        private $userModel;

        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function index() {
            $this->view('home/index', ['title' => 'Users default page']);
        }

        public function register() {
            if (!empty($_POST['username']) && !empty($_POST['email'])
                && !empty($_POST['password']) &&  !empty($_POST['confirm_password'])) {
                $this->userModel = $this->model('User');
                $this->userModel->setUserName($_POST['username']);
                $this->userModel->setPassword($_POST['password']);
                $this->userModel->setEmail($_POST['email']);
                $this->userModel->save();
                $this->view('users/confirm_account');
            }
            else
            {
                $this->view('users/register');
            }
        }
        
        /*
        **  Verifies Whether the user account is already taken or not
        */

        public function verifyUserCredentials() {

        }

        public function login() {
            $this->view('users/login');
        }
    }