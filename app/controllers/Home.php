<?php

    class Home extends Controller 
    {
        private $image;

        public function __construct()
        {
            $this->image = $this->model('Image');
        }

        public function index() {
            Controller::session_init();
            $this->view('home/index');
        }

        public function gallery() {
            Controller::session_init();
            $images = $this->image->getGalleryImages();
            // var_dump($images);die();
            $_SESSION['images'] = $images;
            $this->view('home/gallery');
        }
    }