<?php

require "Database.php";

$db = new Database();
$params = array('owner');

# Get a list of feeders owned by the user
function getFeeders($db, $params) {
    $owner = $db->prepareData($_POST[$params[0]]);
    
    $query = "SELECT * FROM `users_feeders` WHERE `owner` = '{$owner}'";
    
    $feeders = mysqli_query($db->mysqli, $query);

    if (!$feeders) {
        echo "Error: Failed to retrieve feeders.";
        exit();
    }
    
    for ($i = 0; $i < 20; $i++) {
        $row = mysqli_fetch_assoc($feeders); # Get next instance of a row
        
        if ($row == null) {
            if ($i == 0) {
                echo "No feeders found.";
            }
            
            exit();
        }
        
        if (!$row) {
            echo "Error: Failed to retrieve next row.";
            exit();
        }
        
        $mac = $row['mac'];
        $name = $row['name'];
        
        echo "{$mac}\n{$name}\n";
    }
    
    exit();
}

# Check to see if the parameters are set and the database is running
if ($db->runChecks($params)) {
    getFeeders($db, $params);
}
