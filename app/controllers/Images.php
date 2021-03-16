<?php

class Images extends Controller {
    
    public function __construct () {
        $this->image = $this->model('Image');
        $this->sanitizeArray($_POST);
        Controller::session_init();
    }

    private function save($imageData) {
        $creationTimeStamp = time();
        $userid = $_SESSION['logged-in-user']->id;
        $this->image->setName('' . $creationTimeStamp);
        $this->image->setData($imageData);
        $this->image->setOwnerId($userid);
        $queryResult = $this->image->saveImage();
        if ($queryResult) {
            $lastImage = $this->image->getLatestImage();
            echo json_encode($lastImage);
        } else {
            echo json_encode(["error" => "Image can not be saved"]);
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
        $data = json_decode($rawData, true);
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
        $transparency = imagecolorallocatealpha($resized, 0, 0, 0, 0);
        imagefilledrectangle($resized, 0, 0, $width, $height, $transparency);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);
        return $resized;
    }

    public function camera() {
        if (isAuthentified()) {
            $_SESSION['user-images'] = $this->image->getUserImages($_SESSION['logged-in-user']->id);
            $this->view('images/camera');
        } else {
            $this->redirect('users/login');
        }
    }

    public function like() {
        $data = json_decode(file_get_contents('php://input'), true);
        $imageid = $data['id'];
        if (isAuthentified()) {
            if ($imageid != null) {
                $like = new Like($imageid, $_SESSION['logged-in-user']->id);
                if ($like->getLike()) {
                    $like->removeLike();
                    echo json_encode(['liked' => false, 'id' => $imageid, 'likes' => $like->countLikes()->count]);
                } else {
                    $like->addLike();
                    echo json_encode(['liked' => true, 'id' => $imageid, 'likes' => $like->countLikes()->count]);
                }
            }
        } else {
            echo json_encode(['redirectURL' => URLROOT . '/users/login']);
        }
    }

    public function delete() {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['imageid'];
        $this->image->setId($id);
        if ($this->image->deleteImage()) {
            echo json_encode(["state" => true]);
        } else {
            echo json_encode(["state" => false]);
        }
    }

    public function comment() {
        if (isAuthentified()) {
            $data = json_decode(file_get_contents('php://input'), true);
            // $this->sanitizeArray($data);
            $data['commentText'] = htmlspecialchars($data['commentText'], ENT_QUOTES, 'UTF-8');
            // var_dump($data);die();
            $comment = new Comment($data['imageid'], $_SESSION['logged-in-user']->id, $data['commentText']);
            if ($comment->addComment()) {
                // send comment notification to image owner if the notifications are enabled
                $owner = $this->image->getImageOwnerNotify($data['imageid']);
                if ($owner->notify && $owner->owner_id !== $_SESSION['logged-in-user']->id) {
                    $this->sendCommentNotification($owner->email);
                }
                echo json_encode([
                    'state' => true, 
                    'username' => $_SESSION['logged-in-user']->username,
                    ]);
            } else {
                echo json_encode(['state' => false]);
            }
        } else {
            echo json_encode(['redirectURL' => URLROOT . '/users/login']);
        }
    }


    public function sendCommentNotification($email) {
        $subject = "Comment notification";
        $body = "{$_SESSION['logged-in-user']->username} commented on your photo";
        $mailHeaders = "From: abdelilah.khossan@gmail.com\r\n";
        $mailHeaders .= "MIME-Version: 1.0" . "\r\n";
        $mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        mail($email, $subject, $body, $mailHeaders);
    }

}

?>