<?php

require_once('Classes/Todo.php');

switch($_SERVER['REQUEST_METHOD']) {
    case "GET":
        break;

    case "POST":
        $Todo = new Todo;
        $result = $Todo->create($_POST['todoDescription']);
        break;
}

header('Content-Type: application/json');
$jsonString = json_encode($result);
echo $jsonString;