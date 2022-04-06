<?php

require "Database.php";

$db = new Database();
$params = array('mac');

# Get the feeding times of a specific feeder
function getFeedingTimes($db, $params) {
    $mac = $_POST[$params[0]];
    
    $query = "SELECT `feeding_times` FROM `feeders` where `mac` = '{$mac}'";
    $feeding_times = mysqli_query($db->mysqli, $query);

    if (!$feeding_times) {
        echo "Error: Failed to retrieve feeding times.";
        exit();
    }
    
    $row = mysqli_fetch_assoc($feeding_times); # Get next instance of a row
    
    if ($row == null) {
        if ($i == 0) {
            echo "Error: Somehow that device is not in the database.";
        }
        
        exit();
    }
    
    if (!$row) {
        echo "Error: Failed to retrieve next row.";
        exit();
    }
    
    $feeding_times = $row['feeding_times'];
    
    echo "{$feeding_times}";
    
    exit();
}

# Check to see if the parameters are set and the database is running
if (!$db->runChecks($params)) {
    exit();
}

getFeedingTimes($db, $params);
