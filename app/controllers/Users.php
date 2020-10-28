<?php
    class Users extends Controller
    {
        private $userModel;

        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function index() {
            $this->view('pages/index', ['title' => 'Users default page']);
        }

        public function register() {
            // $user = new User();
            $this->userModel = $this->model('User');
            $user->username = $_POST['username'];
            $user->password = $_POST['password'];
            $user->email = $_POST['email'];
            $this->view('users/register', $data = ['user' => $user]);
        }

        public function login() {
            $this->view('users/login');
        }
    }