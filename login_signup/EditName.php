<?php

require "Database.php";

$db = new Database();
$params = array('mac', 'owner', 'name');

# Change the name of a feeder owned by the user
function editName($db, $params) {
    $mac = $_POST[$params[0]];
    $owner = $db->prepareData($_POST[$params[1]]);
    $name = $db->prepareData($_POST[$params[2]]);

    $query = "UPDATE `users_feeders` SET `name` = '{$name}' WHERE `mac` = '{$mac}' AND `owner` = '{$owner}'";

    if (mysqli_query($db->mysqli, $query)) {
        echo "Successfully changed the name of the feeder.";
    } else {
        echo "Failed to change the name of the feeder.";
    }
    
    exit();
}

# Check to see if the parameters are set and the database is running
if (!$db->runChecks($params)) {
    exit();
}

editName($db, $params);
