<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$code = $_POST['code'] ?? '';
$name = $_POST['name'] ?? '';
$cost = $_POST['cost'] ?? '';

if (!empty($code) && !empty($name) && !empty($cost)) {
    $query = "INSERT INTO `procedure` (code, name, cost) VALUES (?, ?, ?)";
    $params = [$code, $name, $cost];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/procedures/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/procedures/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Code, Name and Cost cannot be empty.'); window.location.href='/controllers/procedures/index.php';</script>";
}
