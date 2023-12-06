<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$name = $_POST['name'] ?? '';
$head = $_POST['head'] ?? '';

if (!empty($name) && !empty($head)) {
    $query = "INSERT INTO department (name, head) VALUES (?, ?)";
    $params = [$name, $head];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/departments/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/departments/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Name and Head cannot be empty.'); window.location.href='/controllers/departments/index.php';</script>";
}
