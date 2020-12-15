<?php
    function isAuthentified() {
        return isset($_SESSION['logged-in-user']) && !empty($_SESSION['logged-in-user']);
    }
?>