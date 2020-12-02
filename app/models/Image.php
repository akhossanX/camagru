<?php

class Image {

    private  $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getGalleryImages() {
        $sql = 'select * from image';
        $this->db->query($sql);
        return $this->db->resultset();
    }
}