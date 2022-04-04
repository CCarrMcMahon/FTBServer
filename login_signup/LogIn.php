<?php

require "Database.php";

$db = new Database();
$params = array('username', 'password');

# Function to check if a provided username and password are in the database
function logIn($db, $params) {
    $username = $db->prepareData($_POST[$params[0]]);
    $password = $_POST[$params[1]];
    
    $query = "SELECT * FROM `users` WHERE `username` = '{$username}'";
    
    $result = mysqli_query($db->mysqli, $query);
    
    if ($result->num_rows == 0) {
        return false;
    }
    
    $row = mysqli_fetch_assoc($result); # Get first instance of row
    
    $dbusername = $db->prepareData($row['username']);
    $dbpassword = $row['password'];
    
    if ($dbusername == $username && password_verify($password, $dbpassword)) {
        echo "Successfully logged in.";
    } else {
        echo "Your username or password is incorrect.";
    }
}

# Check to see if the parameters are set and the database is running
if (!$db->runChecks($params)) {
    exit();
}

logIn($_POST['username'], $_POST['password']);
