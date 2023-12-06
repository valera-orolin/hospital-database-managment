<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$departmentid = $_POST['departmentid'];
$name = $_POST['name'] ?? '';
$head = $_POST['head'] ?? '';

if (!empty($name) && !empty($head)) {
    $query = "UPDATE department SET name = ?, head = ? WHERE departmentid = ?";
    $params = [$name, $head, $departmentid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/departments/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/departments/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Name and Head cannot be empty.'); window.location.href='/controllers/departments/index.php';</script>";
}
