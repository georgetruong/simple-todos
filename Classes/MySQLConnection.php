<?php

// A simple wrapper for mysqli

require_once("MySQLConfig.php");

class MySQLConnection {
    private $servername;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function __construct() {
        $this->servername   = MYSQL_SERVERNAME;
        $this->username     = MYSQL_USERNAME;
        $this->password     = MYSQL_PASSWORD;
        $this->database     = MYSQL_DATABASE;
        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function close() {
        $this->conn->close();
    }

    public function lastInsertId() {
        return $this->conn->insert_id;
    }
}