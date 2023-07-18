<?php
    $fname='';
    //define variables and set to empty values
    $firstnameErr = $lastnameErr= $emailErr = $genderErr = $websiteErr  = "";
    $firstname = $lastname = $email = $gender = $comments = $website = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    $fname=$_POST["firstname"];
        if (empty($_POST["firstname"])) {
            $nameErr = "Firstname is required";
        } else {
            $name = test_input($_POST["firstname"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-']*$/", $firstname)) {
                $firstnameErr = "Only letters and white spaces allowed for a firstname";
            }
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["lastname"])) {
                $nameErr = "Lastname is required";
            } else {
                $name = test_input($_POST["lastname"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-']*$/", $name)) {
                    $nameErr = "Only letters and white spaces allowed for a lastname";
                }
            }



        if (empty($_POST["email"])) {
            $emailErr = "email is required";
        } else {
            $email = test_input($_POST["email"]);
            //check if email address is well formated
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["website"])) {
            $website = "";
        } else {
            $website = test_input($_POST["website"]);
            //check if URL address syntax is valid
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%=~_|]/i", $website)) {
                $websiteErr = "Invalid URL";
            }
        }


        if (empty($_POST["comment"])) {
            $comment = "";
        } else {
            $comment = test_input($_POST["comment"]);
        }

        if (empty($_POST["gender"])) {
            $genderErr = "gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }
    }


    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }