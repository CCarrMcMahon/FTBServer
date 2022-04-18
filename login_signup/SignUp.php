<?php

require "Database.php";

$db = new Database();
$params = array('email', 'username', 'password');

function signUp($db, $params) {
    $email = $db->prepareData($_POST[$params[0]]);
    $username = $db->prepareData($_POST[$params[1]]);
    $password = password_hash($_POST[$params[2]], PASSWORD_DEFAULT);
    
    $query = "INSERT INTO `users` (`email`, `username`, `password`) VALUES ('{$email}', '{$username}', '{$password}')";
    
    if (mysqli_query($db->mysqli, $query)) {
        echo "Successfully signed up.";
    } else {
        echo "That email or username is already in use.";
    }
}

# Check to see if the parameters are set and the database is running
if (!$db->runChecks($params)) {
    exit();
}

signUp($db, $params);
