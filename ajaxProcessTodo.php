<?php

require_once('Classes/Todo.php');

$Todo = new Todo;
switch($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (isset($_GET['id'])) {
            $result = $Todo->fetch($_GET['id']);
        } else {
            // TODO: fetch all
            $result = $Todo->fetchAll();
        }
        break;

    case "POST":
        $result = $Todo->create($_POST['todoDescription']);
        break;
}

header('Content-Type: application/json');
$jsonString = json_encode($result);
echo $jsonString;