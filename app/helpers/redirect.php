<?php
    function redirect($view) {
        if (file_exists('app/views/' . $view . '.php'))
            return header("Location: " . URLROOT . '/' . $view);
        else 
            return header("Location: " . URLROOT . '/helpers/error_404.php');
    }
?>
