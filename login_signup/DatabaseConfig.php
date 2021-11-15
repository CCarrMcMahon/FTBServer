<?php

class DatabaseConfig {
    public $url;
    public $username;
    public $password;
    public $database;

    public function __construct() {
        $this->url = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->database = 'feed_the_beast';
    }
}

?>
