<?php

    class Home extends Controller 
    {
        private $image;

        public function __construct()
        {
            $this->image = $this->model('Image');
        }

        public function index() {
            $data = [
                'title' => 'Welcome to Camagru',
            ];
            $this->view('home/index', $data);
        }

        public function gallery() {
            $data = [];
            $images = $this->image->getGalleryImages();
            $data['images'] = $images;
            // var_dump($images);die();
            $this->view('home/gallery', $data);
        }
    }