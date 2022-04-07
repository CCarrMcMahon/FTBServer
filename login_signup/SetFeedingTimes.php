<?php

require "Database.php";

$db = new Database();
$params = array('mac', 'feeding_times');

# Set the feeding times of a specific feeder
function setFeedingTimes($db, $params) {
    $mac = $_POST[$params[0]];
    $feeding_times = $_POST[$params[1]];
    
    $query = "UPDATE `feeders` SET `feeding_times` = '{$feeding_times}' WHERE `mac` = '{$mac}'";

    if (!mysqli_query($db->mysqli, $query)) {
        echo "Failed to update the feeding times.";
    }
    
    exit();
}

# Check to see if the parameters are set and the database is running
if ($db->runChecks($params)) {
    setFeedingTimes($db, $params);
}
