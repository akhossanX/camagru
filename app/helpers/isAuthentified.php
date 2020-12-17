<?php
    function isAuthentified() {
        $user = null;
        if (isset($_SESSION['logged-in-user']))
            $user = $_SESSION['logged-in-user'];
        return $user != null;
    }
?>