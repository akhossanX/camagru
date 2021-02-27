<?php
    require_once 'BaseModel.php';

class Like extends BaseModel {

    private $imageId;
    private $userId;

    public function __construct($imageId = null, $userId = null) {
        parent::__construct();
        $this->userId = $userId;
        $this->imageId = $imageId;
    }
    /*
    **  Getters and setters
    */
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function setImageId($imageId) {
        $this->imageId = $imageId;
    }
    public function getImageId() {
        return $this->imageId;
    }

    public function addLike() {
        $sql = "INSERT INTO `like` (user_id, image_id) values (:userid, :imageid);";
        $this->query($sql);
        $this->bind(":imageid", $this->imageid);
        $this->bind(":userid", $this->userid);
        $this->execute();
    }

    public function removeLike() {
        $sql = "DELETE FROM `like` WHERE user_id LIKE :userid AND image_id LIKE :imageid";
        $this->query($sql);
        $this->bind(":userid", $this->userid);
        $this->bind(":imageid", $this->imageid);
        $this->execute();
    }

    public function countLikes() {
        $sql = "SELECT COUNT(*) AS likes FROM `like` WHERE like.image_id LIKE :imageid";
        $this->query($sql);
        $this->bind(":imageid", $this->imageId);
        return $this->single();
    }

}