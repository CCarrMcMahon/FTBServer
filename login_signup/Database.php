<?php

require "DatabaseConfig.php";

class Database {
    public $mysqli;
    public $data;
    
    protected $url;
    protected $username;
    protected $password;
    protected $database;

    public function __construct() {
        $this->mysqli = null;
        $this->data = null;
        
        $dbc = new DatabaseConfig();
        
        $this->url = $dbc->url;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->database = $dbc->database;
    }

    function connect() {
        $this->mysqli = mysqli_connect($this->url, $this->username, $this->password, $this->database);
        return $this->mysqli;
    }

    function prepareData($data) {
        if ($this->mysqli == null) {
            return;
        }

        return mysqli_real_escape_string($this->mysqli, stripslashes(htmlspecialchars($data)));
    }

    function runChecks($values) {
        # Check if all post values are set
        foreach ($values as $value) {
            if (!isset($_POST[$value])) {
                echo "All fields are required.";
                return false;
            }
        }
    
        # Check if we could connect to the database
        if (!$this->connect()) {
            echo "Error: Could not connect to the Database.";
            return false;
        }

        return true;
    }
}
