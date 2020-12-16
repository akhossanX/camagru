<?php
    function isAuthentified() {
        $user = $_SESSION['logged-in-user'];
        return $user != null;
    }
?>