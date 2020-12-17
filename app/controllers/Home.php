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
            require_once(APPROOT . '/helpers/isAuthentified.php');
            if (isAuthentified()) {
                return $this->redirect('users/camera');
            }
            $this->view('home/index');
        }

        public function gallery() {
            Controller::session_init();
            $images = $this->image->getGalleryImages();
            $_SESSION['images'] = $images;
            $this->view('home/gallery');
        }
    }