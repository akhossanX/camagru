<?php

    class Home extends Controller 
    {
        private $image;

        public function __construct() {
            $this->image = $this->model('Image');
            $this->sanitizeArray($_POST);
            Controller::session_init();
        }

        public function index() {
            return $this->redirect('home/gallery');
        }

        public function gallery() {
            $_SESSION['gallery'] = $this->image->getPosts();
            $this->view('home/gallery');
        }

        public function lazyLoad() {
            $xhrData = json_decode(file_get_contents("php://input"), true);
            $data = $this->image->getPosts($from = $xhrData['postsOffset']);
            echo json_encode($data);
        }
    }