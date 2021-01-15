<?php
    require_once 'BaseModel.php';

class Image extends BaseModel {

    private $name;
    private $userid;
    private $data;

    public function __construct() {
        parent::__construct();
    }
    /*
    **  Getters and setters
    */
    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
    public function setData($data) {
        $this->data = $data;
    }
    public function getData() {
        return $this->data;
    }

    public function getGalleryImages() {
        $this->query('SELECT * from public_gallery_images');
        return $this->resultset();
    }

    public function saveUserImage($userId) {
        $sql = 'INSERT INTO image (name, data, user_id) values (:name, :data, :user_id)';
        $this->query($sql);
        $this->bind(':name', $this->name);
        $this->bind(':data', $this->data);
        $this->bind(':user_id', $userId);
        return $this->execute();
    }

}