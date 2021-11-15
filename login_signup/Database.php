<?php

require "DatabaseConfig.php";

class Database {
    public $connect;
    public $data;
    private $sql;
    protected $url;
    protected $username;
    protected $password;
    protected $database;

    public function __construct() {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DatabaseConfig();
        $this->url = $dbc->url;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->database = $dbc->database;
    }

    function dbConnect() {
        $this->connect = mysqli_connect($this->url, $this->username, $this->password, $this->database);
        return $this->connect;
    }

    function prepareData($data) {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $username, $password) {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        
        $this->sql = "select * from {$table} where username = '" . $username . "'";
        
        $result = mysqli_query($this->connect, $this->sql);
        
        if (mysqli_num_rows($result) != 0) {
            $row = mysqli_fetch_assoc($result);
            
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            
            if ($dbusername == $username && password_verify($password, $dbpassword)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function signUp($table, $email, $username, $password) {
        $email = $this->prepareData($email);
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $this->sql =
            "INSERT INTO {$table} (email, username, password) VALUES ('" . $email . "', '" . $username . "', '" . $password . "')";
        
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else {
            #echo mysqli_error($this->connect);
            return false;
        }
    }
}

?>
