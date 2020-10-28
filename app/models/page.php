<?php

class Page {

    public  $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getGalleryImages() {
        $sql = 'select * from image where ';
        $this->db->query($sql);
    }
}