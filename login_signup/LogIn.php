<?php

require "Database.php";

$db = new Database();

# Function to check if a provided username and password are in the database
function logIn($username, $password) {
    global $db;
    
    $username = $db->prepareData($username);
    
    $query = "SELECT * FROM `users` WHERE `username` = '{$username}'";
    
    $result = mysqli_query($db->mysqli, $query);
    
    if (mysqli_num_rows($result) == 0) {
        return false;
    }
    
    $row = mysqli_fetch_assoc($result); # Get first instance of row
    
    $dbusername = $db->prepareData($row['username']);
    $dbpassword = $row['password'];
    
    if ($dbusername == $username && password_verify($password, $dbpassword)) {
        return true;
    } else {
        return false;
    }
}

# Make sure all data has been sent over
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "All fields are required.";
    exit();
}

# Check if we could connect to the database
if (!$db->connect()) {
    echo "Error: Could not connect to the Database.";
    exit();
}

# Check if the username and password combination are in the database
if (logIn($_POST['username'], $_POST['password'])) {
    echo "Successfully logged in.";
} else {
    echo "Your username or password is incorrect.";
}
