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

    public function getLike() {
        $sql = "SELECT * FROM `like` WHERE image_id=:imageid AND user_id=:userid";
        $this->query($sql);
        $this->bind(":imageid", $this->imageId);
        $this->bind(":userid", $this->userId);
        return $this->single();
    }

    public function addLike() {
        $sql = "INSERT INTO `like` (user_id, image_id) values (:userid, :imageid);";
        $this->query($sql);
        $this->bind(":imageid", $this->imageId);
        $this->bind(":userid", $this->userId);
        return $this->execute();
    }

    public function removeLike() {
        $sql = "DELETE FROM `like` WHERE user_id LIKE :userid AND image_id LIKE :imageid";
        $this->query($sql);
        $this->bind(":userid", $this->userId);
        $this->bind(":imageid", $this->imageId);
        $this->execute();
    }

    public function countLikes() {
        $sql = "SELECT COUNT(*) AS `count` FROM `like` WHERE like.image_id LIKE :imageid";
        $this->query($sql);
        $this->bind(":imageid", $this->imageId);
        return $this->single();
    }

}