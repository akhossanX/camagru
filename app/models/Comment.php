<?php
    require_once 'BaseModel.php';

class Comment extends BaseModel {

    private $imageId;
    private $userId;
    private $text;

    public function __construct($imageId=null, $userId=null, $text=null) {
        parent::__construct();
        $this->imageId = $imageId;
        $this->userId = $userId;
        $this->text = $text;
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
    public function setText($text) {
        $this->text = $text;
    }
    public function getText() {
        return $this->text;
    }

    public function getComments() {
        $sql = "SELECT user.username, comment.text
            FROM comment 
            JOIN image 
            ON image.id=comment.image_id AND image.id=:imageid 
            JOIN user 
            ON user.id=comment.user_id
            ORDER BY comment.id
        ";
        $this->query($sql);
        $this->bind(":imageid", $this->imageId);
        return $this->resultset();
    }

    public function addComment() {
        $sql = "INSERT INTO comment (image_id, user_id, text) values (:imageid, :userid, :text)";
        $this->query($sql);
        $this->bind(":imageid", $this->imageId);
        $this->bind(":userid", $this->userId);
        $this->bind(":text", $this->text);
        return $this->execute();
    }
}