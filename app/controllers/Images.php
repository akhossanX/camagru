<?php

class Images extends Controller {
    
    public function __construct () {
        $this->image = $this->model('Image');
        Controller::session_init();
    }

    private function save($imageData)
    {
        $creationTimeStamp = time();
        $this->image->setName('' . $creationTimeStamp);
        $this->image->setData($imageData);
        $queryResult = $this->image->saveUserImage($_SESSION['logged-in-user']->id);
        if ($queryResult) {
            // make a Query to send the later saved picture to client
            // and all its informations including comments likes....
            echo $imageData;
        } else {
            echo 'Error: Image can not be saved';
        }
    }

    public function get() {
        if (isAuthentified()) {
            $rawData = file_get_contents('php://input');
            if ($rawData) {
                $assembledImage = $this->superposeImages($rawData);
                ob_start();
                $data = imagepng($assembledImage);
                $data = ob_get_contents();
                ob_end_clean();
                $data = base64_encode($data);
                $this->save($data);
            } else {
                $this->redirect('home/index');
            }
        } else {
            $this->redirect('home/index');
        }
    }
    
    private function superposeImages($rawData) {
        $data = json_decode($rawData, true);// returns associative array
        $image = base64_decode($data['image']);
        // die($data['image']);
        $image = imagecreatefromstring($image);
        if ($image === false)
            die("can't create image from string");
        $stickers = $data['stickers'];
        $pngs = [];
        foreach ($stickers as $sticker) {
            $width = $sticker["width"];
            $height = $sticker["height"];
            $png = imagecreatefrompng( ROOT . "/public/img/" . $sticker["src"] );
            if ($png === false) {
                die("can't create png image from path");
            }
            $png = $this->resizeImage($png, $width, $height);
            if (!imagecopy($image, $png, $sticker["x"], $sticker["y"], 0, 0, $width, $height))
                die('could not merge pictures :-(');
        }
        return $image;
    }

    private function resizeImage($img, $width, $height) {
        $oldWidth = imagesx($img);
        $oldHeight = imagesy($img);
        $resized = imagecreatetruecolor($width, $height);
        imagealphablending($resized, false);
        imagesavealpha($resized,true);
        $transparency = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefilledrectangle($resized, 0, 0, $width, $height, $transparency);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);
        return $resized;
    }

    public function preview() {
        if (isAuthentified()) {
            // $images = $this->

        }
    }
}

?>