<?php

require "Database.php";

$db = new Database();

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        if ($db->logIn("users", $_POST['username'], $_POST['password'])) {
            echo "Successfully logged in.";
        } else {
            echo "Your username or password is incorrect.";
        }
    } else {
        echo "Error: Could not connect to the Database.";
    }
} else {
    echo "All fields are required.";
}

?>
