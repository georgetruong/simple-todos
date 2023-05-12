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

    public function fetch($id) {
        $sql = "SELECT id, description FROM todo WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $description);
        $stmt->fetch();

        return Array('id' => $id, 'description' => $description);
    }

    public function create($description) {
        $sql = 'INSERT INTO todo (description) VALUES (?)';
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param('s', $description);
        if($stmt->execute()) {
            $result = $this->fetch($this->db->lastInsertId());
        } else {
            $result = Array('id' => null, 'description' => null);
        }

        return $result;
    }

}