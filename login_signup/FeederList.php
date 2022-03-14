<?php

require "Database.php";

$db = new Database();

# Get a list of feeders owned by the user
function getFeeders($username) {
    global $db;
    
    $username = $db->prepareData($username);
    
    $query = "SELECT * FROM `feeders` WHERE `owner` = '{$username}'";
    
    return mysqli_query($db->mysqli, $query);
}

# Make sure all data has been sent over
if (!isset($_POST['username'])) {
    echo "A username must be provided.";
    exit();
}

# Check if we could connect to the database
if (!$db->connect()) {
    echo "Error: Could not connect to the Database.";
    exit();
}

$feeders = getFeeders($_POST['username']);

if (!$feeders) {
    echo "Error: Failed to retrieve feeders.";
    exit();
}

$loop = 0;

while ($loop < 20) {
    $row = mysqli_fetch_assoc($feeders); # Get next instance of a row
    
    if ($row == null) {
        if ($loop == 0) {
            echo "No feeders found.";
        }
        
        exit();
    }
    
    if (!$row) {
        echo "Error: Failed to retrieve next row.";
        exit();
    }
    
    $name = $row['name'];
    $owner = $row['owner'];
    
    echo "{$name}\n";
    
    $loop++;
}
