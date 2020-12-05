<?php
    require_once 'BaseModel.php';

class Image extends BaseModel {

    private $name;
    private $userid;
    private $data;

    public function __construct()
    {
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
        $query = 'CREATE VIEW image_view AS SELECT u.username,i.data FROM image as i, user as u WHERE i.user_id=u.id';
        $this->query('SELECT * from image_view');
        return $this->resultset();
    }

}