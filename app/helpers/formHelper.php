<?php

    function checkFormFields($arr) {
        foreach ($arr as $field) {
            if (!isset($_POST[$field])) 
                return false;
        }
        return true;
    }

?>