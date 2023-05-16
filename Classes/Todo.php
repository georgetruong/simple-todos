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

    public function fetchAll() {
        $sql = "SELECT id, description FROM todo";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function delete($todoId) {
        if (!isset($todoId)) return Array('id' => null);

        $sql = "DELETE FROM todo WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $todoId);

        if ($stmt->execute()) {
            $result = Array('id' => $todoId);
        } else {
            $result = Array('id' => null);
        }

        return $result;
    }

    public function update($todoId, $todoDescription) {
        if (!isset($todoId)) return Array('id' => null);
        if (!isset($todoDescription)) return Array('id' => null);

        $sql = "UPDATE todo SET description = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $todoDescription, $todoId);
        $stmt->execute();

        return $this->fetch($todoId);
    }
}