<?php

    class Pages extends Controller 
    {
        public function __construct()
        {
            $this->model = $this->model('page');
        }

        public function index() {
            $data = [
                'title' => 'Welcome to Camagru',
            ];
            $this->view('pages/index', $data);
        }

        public function about() {
            $data = [
                'title' => 'About Us'
            ];
            $this->view('pages/about', $data);
        }

        public function gallery() {
            $data = [];
            $this->view('pages/gallery', $data);
        }
    }