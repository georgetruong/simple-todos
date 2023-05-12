<?php

require_once('MySQLConnection.php');

class Todo {

    private $db;

    public function __construct() {
        $this->db = new MySQLConnection();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function create($description, $priority) {
        $sql = 'INSERT INTO todo (description) VALUES (?)';
        $stmt = $this->db->prepare($sql);

        // NOTE: First param of function call defines types
        // https://www.php.net/mysqli-stmt.bind-param
        $stmt->bind_param('s', $description);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

}