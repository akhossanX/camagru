<?php 

    function validateEmail($email) {
        $re = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/";
        if (preg_match($re, $email) === 0) {
            return  'invalid email';
        }
        return "";
    }

    function validateUserName($username) {
        if (preg_match('/^(?=.{8,20}$)(?![._])(?!.*[._]{2})[\w.]+(?<![_.])$/', $username) === 0) {
            return 'username must contain [a-zA-Z0-9_] and must be 8 up to 20 characters.';
        }
        return "";
    }

    function validatePassword($password) {
        $regex = "/^(?=\S{8,20}$)(?=.*\d+.*)(?=.*[a-z_]+.*)+(?=.*[A-Z].*)+(?=.*[!@#$%^&*()]+.*)/";
        if (preg_match($regex, $password) === 0) {
            return "Must contain at least a-zA-Z0-9 and at least one of '!@#$%^&*()' and 8 up to 20 characters";
        }
        return "";
    }

    function hasErrors($arr) {
        foreach ($arr as $errname => $errmessage) {
            if (strpos($errname, "_error") !== false) {
                if ($errmessage !== "") {
                    return true;
                }
            }
        }
        return false;
    }

?>