<?php

require "Database.php";

$db = new Database();

function signUp($email, $username, $password) {
    global $db;
    
    $email = $db->prepareData($email);
    $username = $db->prepareData($username);
    
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO `users` (`email`, `username`, `password`) VALUES ('{$email}', '{$username}', '{$password}')";
    
    if (mysqli_query($db->mysqli, $query)) {
        return true;
    } else {
        return false;
    }
}

# Make sure all data has been sent over
if (!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST['password'])) {
    echo "All fields are required.";
    exit();
}

# Check if we could connect to the database
if (!$db->connect()) {
    echo "Error: Could not connect to the Database.";
    exit();
}

# Check if the user signed up successfully
if (signUp($_POST['email'], $_POST['username'], $_POST['password'])) {
    echo "Successfully signed up.";
} else {
    echo "That email or username is already in use.";
}
