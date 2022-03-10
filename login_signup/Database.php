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
        return mysqli_real_escape_string($this->mysqli, stripslashes(htmlspecialchars($data)));
        # return mysqli_real_escape_string($this->mysqli, $data);
    }
}
