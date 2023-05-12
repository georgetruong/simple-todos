<?php

require_once('Classes/Todo.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Todo = new Todo;
    $Todo->create($_POST['todoDescription'], $_POST['todoPriority']);
}
else {
    echo 'NOTHING POSTED';
}