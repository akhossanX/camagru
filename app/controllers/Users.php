<?php
    class Users extends Controller
    {
        public function __construct()
        {
            // $this->userModel = $this->model('User');
        }

        public function index() {
            $this->view('pages/index', ['title' => 'Users default page']);
        }

        public function register() {
            $this->view('users/register');
        }

        public function login() {
            $this->view('users/login');
        }
    }