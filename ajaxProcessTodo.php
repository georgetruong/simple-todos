<?php

require_once('Classes/Todo.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Todo = new Todo;
    $result = $Todo->create($_POST['todoDescription']);

    $jsonString = json_encode($result);
    echo $jsonString;
}