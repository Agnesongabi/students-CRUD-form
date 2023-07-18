<?php

function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function isFieldEmpty($name)  {
        if (empty($name)) {
            return "This field is required";
        }
        return 1;
    }

    function validateField($name, $descr) {
        if ($descr == 'fname' || $descr == 'lname') {
            if (!preg_match("/^[a-zA-Z-']*$/", $name)) {
                return "Only letters and white spaces allowed for a name";
            }
        }

        if ($descr=='email') {
            if (!filter_var($name, FILTER_VALIDATE_EMAIL)) {
                return "Invalid email format";
            }
        }

        if ($descr=='website') {
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%=~_|]/i", $name)) {
                return "Invalid URL";
            }
        }
    }