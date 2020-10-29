<?php

    class Home extends Controller 
    {
        public function __construct()
        {
            $this->model = $this->model('page');
        }

        public function index() {
            $data = [
                'title' => 'Welcome to Camagru',
            ];
            $this->view('home/index', $data);
        }

        public function about() {
            $data = [
                'title' => 'About Us'
            ];
            $this->view('home/about', $data);
        }

        public function gallery() {
            $data = [];
            $this->view('home/gallery', $data);
        }
    }