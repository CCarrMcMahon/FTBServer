<?php

require "Database.php";

$db = new Database();
$params = array('mac', 'owner', 'name');

# Get a list of feeders owned by the user
function addFeeder($db, $params) {
    $mac = $_POST[$params[0]];
    $owner = $db->prepareData($_POST[$params[1]]);
    $name = $db->prepareData($_POST[$params[2]]);
    
    $query = "SELECT * FROM `users_feeders` WHERE `mac` = '{$mac}' AND `owner` = '{$owner}'";
    
    $feeders = mysqli_query($db->mysqli, $query);
    
    if (!$feeders) {
        echo "Failed to get your feeders.";
        exit();
    }
    
    if ($feeders->num_rows != 0) {
        echo "You already own this feeder.";
        exit();
    }
    
    $query = "INSERT INTO `users_feeders` (`mac`, `owner`, `name`) values ('{$mac}', '{$owner}', '{$name}')";

    if (mysqli_query($db->mysqli, $query)) {
        echo "Successfully added the feeder.";
        $query = "INSERT INTO `feeders` (`mac`) values ('{$mac}')";
        mysqli_query($db->mysqli, $query);
    } else {
        echo "Failed to add the feeder.";
    }
    
    exit();
}

# Check to see if the parameters are set and the database is running
if ($db->runChecks($params)) {
    addFeeder($db, $params);
}
