<?php

    class Home extends Controller 
    {
        private $image;
        private $data = Array();

        public function __construct()
        {
        }

        public function index() {
            $data = [
                'title' => 'Welcome to Camagru',
            ];
            $this->view('home/index', $data);
        }

        public function gallery() {
            $this->image = $this->model('Image');
            $this->data['images'] = $this->image->getGalleryImages();
            $this->view('home/gallery', $this->data);
        }
    }