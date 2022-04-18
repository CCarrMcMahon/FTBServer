<?php

require "Database.php";

$db = new Database();
$params = array('mac', 'owner');

# Change the name of a feeder owned by the user
function removeFeeder($db, $params) {
    $mac = $_POST[$params[0]];
    $owner = $db->prepareData($_POST[$params[1]]);

    $query = "DELETE FROM `users_feeders` WHERE `mac` = '{$mac}' AND `owner` = '{$owner}'";

    if (mysqli_query($db->mysqli, $query)) {
        echo "Successfully removed the feeder.";
    } else {
        echo "Failed to remove the feeder.";
    }
    
    $query = "DELETE FROM `feeders` WHERE `mac` NOT IN (SELECT `mac` FROM `users_feeders`)";
    
    mysqli_query($db->mysqli, $query);
    exit();
}

# Check to see if the parameters are set and the database is running
if ($db->runChecks($params)) {
    removeFeeder($db, $params);
}
