<?php

class Images extends Controller {
    
    public function __construct () {
        $this->image = $this->model('Image');
        Controller::session_init();
    }

    public function save () {
        if (isAuthentified()) {
            $rawData = file_get_contents('php://input');
            if ($rawData) {
                $assembledImage = $this->superposeImages($rawData);
                ob_start();
                $data = imagepng($assembledImage);
                $data = ob_get_contents();
                ob_end_clean();
                echo base64_encode($data);

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
            imagecopymerge($image, $png, $sticker["x"], $sticker["y"], 0, 0, $width, $height, 0);
        }
        return $image;
    }

    private function resizeImage($img, $width, $height) {
        $oldWidth = imagesx($img);
        $oldHeight = imagesy($img);
        $resized = imagecreatetruecolor($width, $height);
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