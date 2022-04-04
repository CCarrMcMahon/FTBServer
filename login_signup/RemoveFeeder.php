<?php

require "Database.php";

$db = new Database();
$params = array('mac', 'owner', 'name');

# Change the name of a feeder owned by the user
function removeFeeder($db, $params) {
    $mac = $_POST[$params[0]];
    $owner = $db->prepareData($_POST[$params[1]]);
    $name = $db->prepareData($_POST[$params[2]]);

    $query = "DELETE FROM `feeders` WHERE `mac` = '{$mac}' AND `owner` = '{$owner}' AND `name` = '{$name}'";

    if (mysqli_query($db->mysqli, $query)) {
        echo "Successfully removed the feeder.";
        exit();
    } else {
        echo "Failed to remove the feeder.";
        exit();
    }
}

# Check to see if the parameters are set and the database is running
if (!$db->runChecks($params)) {
    exit();
}

removeFeeder($db, $params);
