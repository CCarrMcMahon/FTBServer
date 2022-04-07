<?php
#id=connect&ssid=MyNetwork&password=password&mac=mac
require "Database.php";

$db = new Database();
$packets_array = array('animal');
$animal_params = array('mac');
date_default_timezone_set("America/Chicago");

function checkPostValues($values) {
    # Check if all post values are set
    foreach ($values as $value) {
        if (!isset($_POST[$value])) {
            echo "All fields are required.";
            return false;
        }
    }
    
    return true;
}

function handleAnimal($db, $params) {
    $mac = $_POST[$params[0]];
    
    $query = "SELECT `feeding_times` FROM `feeders` where `mac` = '{$mac}'";
    $feeding_times = mysqli_query($db->mysqli, $query);

    if (!$feeding_times) {
        echo "Error: Failed to retrieve feeding times.";
        exit();
    }
    
    $row = mysqli_fetch_assoc($feeding_times); # Get next instance of a row
    
    if ($row == null) {
        echo "Error: Somehow that device is not in the database.";
        exit();
    }
    
    if (!$row) {
        echo "Error: Failed to retrieve next row.";
        exit();
    }
    
    $feeding_times = $row['feeding_times'];
    $values = json_decode($feeding_times, true);
    
    $values_index = 0;
    $found_time = false;
    
    # Check if all post values are set
    foreach ($values as $value) {
        $start_time = $value['startTime'];
        $end_time = $value['endTime'];
        $cups = $value['cups'];
        $ate = $value['ate'];
        
        # If the current time falls within range of the feeding time
        if (strtotime($start_time) <= time() && time() <= strtotime($end_time)) {
            $found_time = true;
            
            if ($ate) {
                echo "id=givefood&cups=0\n";
                exit();
            }
            
            echo "id=givefood&cups={$cups}\n";
            break;
        }
        
        $values_index++;
    }
    
    if (!$found_time) {
        echo "id=givefood&cups=0\n";
        exit();
    }
    
    $values[$values_index]['ate'] = true;
    $feeding_times = json_encode($values);
    
    $query = "UPDATE `feeders` SET `feeding_times` = '{$feeding_times}' WHERE `mac` = '{$mac}'";
    
    if (!mysqli_query($db->mysqli, $query)) {
        echo "Failed to update the feeding times.";
    }
    
    exit();
}

# Check if we couldn't connect to the database
if (!$db->connect()) {
    echo "Error: Could not connect to the Database.";
    exit();
}

# Check to see if the ID is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    if ($id == $packets_array[0]) {
        if (checkPostValues($animal_params)) {
            handleAnimal($db, $animal_params);
        }
    }
    
}
