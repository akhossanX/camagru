<?php

class Images extends Controller {
    
    public function __construct () {
        $this->image = $this->model('Image');
        Controller::session_init();
    }

    public function save_picture () {
        if (isAuthentified()) {
            if (isset($_POST) && isset($_POST['pic'])) {
                // Grab image data (base64 encoded) and make a query to save it in database
                echo $_POST;
                $imgData = substr($_POST['pic'], strpos($_POST['pic'], ',') + 1);
                // print('Image Data' . PHP_EOL . $imgData);
                $this->image->setData($imgData);
                $this->image->setName($_SESSION['username'] . '_' . time() . '_gallery' . '.png');
                $this->image->saveUserImage($_SESSION['logged-in-user']->id);
            } else {
                $this->redirect('home/index');
            }
        } else {
            $this->redirect('home/index');
        }
    }
}


?>