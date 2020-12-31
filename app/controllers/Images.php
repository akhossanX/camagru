<?php

class Images extends Controller {
    
    public function __construct () {
        $this->image = $this->model('Image');
        Controller::session_init();
    }

    public function save () {
        if (isAuthentified()) {
        
            var_dump($_POST);
            // $imgData = "";
            // while (!feof($putdata)) {
            //     $imgData .= fread($putdata, 1024);
            // }
            // if (isset($_POST) ) {
            //     $this->image->setData($imgData);
            //     $this->image->setName($_SESSION['username'] . '_' . time() . '_gallery' . '.png');
            //     $this->image->saveUserImage($_SESSION['logged-in-user']->id);
            // } else {
            //     $this->redirect('home/index');
            // }
        } else {
            $this->redirect('home/index');
        }
    }

    public function preview() {
        if (isAuthentified()) {
            // $images = $this->

        }
    }
}


?>