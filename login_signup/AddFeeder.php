<?php

require "Database.php";

$db = new Database();

# Get a list of feeders owned by the user
function addFeeder($mac, $owner, $name) {
    global $db;
    
    $owner = $db->prepareData($owner);
    
    $query = "SELECT * FROM `feeders` WHERE `mac` = '{$mac}' AND `owner` = '{$owner}'";
    
    $feeders = mysqli_query($db->mysqli, $query);
    
    if (!$feeders) {
        echo "Failed to get your feeders.";
        exit();
    }
    
    if ($feeders->num_rows != 0) {
        echo "You already own this feeder.";
        exit();
    }
    
    $query = "INSERT INTO `feeders` (`mac`, `owner`, `name`) values ('{$mac}', '{$owner}', '{$name}')";

    if (mysqli_query($db->mysqli, $query)) {
        echo "Successfully added the feeder.";
        exit();
    } else {
        echo "Failed to add the feeder.";
        exit();
    }
}

# Make sure all data has been sent over
if (!isset($_POST['mac']) || !isset($_POST['owner']) || !isset($_POST['name'])) {
    echo "All fields are required.";
    exit();
}

# Check if we could connect to the database
if (!$db->connect()) {
    echo "Error: Could not connect to the Database.";
    exit();
}

addFeeder($_POST['mac'], $_POST['owner'], $_POST['name']);
