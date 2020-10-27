<?php

class Page {

    public  $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getGalleryImages() {
        $sql = '';
        $this->db->prepare($sql);
    }
}