<?php

require "Database.php";

$db = new Database();

if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        if ($db->signUp("users", $_POST['email'], $_POST['username'], $_POST['password'])) {
            echo "Successfully signed up.";
        } else {
            echo "That email or username is already in use.";
        }
    } else {
        echo "Error: Could not connect to the Database.";
    }
} else {
    echo "All fields are required.";
}

?>
