<?php

require_once('Classes/Todo.php');

$Todo = new Todo;
switch($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (isset($_GET['id'])) {
            $result = $Todo->fetch($_GET['id']);
        } else {
            $result = $Todo->fetchAll();
        }
        break;

    case "POST":
        $result = $Todo->create($_POST['todoDescription']);
        break;

    case "DELETE":
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        $result = $Todo->delete($data['id']);
        break;
}

header('Content-Type: application/json');
$jsonString = json_encode($result);
echo $jsonString;