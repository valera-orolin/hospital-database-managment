<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$procedureid = $_POST['procedureid'];
$code = $_POST['code'] ?? '';
$name = $_POST['name'] ?? '';
$cost = $_POST['cost'] ?? '';

if (!empty($code) && !empty($name) && !empty($cost)) {
    $query = "UPDATE `procedure` SET code = ?, name = ?, cost = ? WHERE procedureid = ?";
    $params = [$code, $name, $cost, $procedureid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/procedures/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/procedures/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Code, Name and Cost cannot be empty.'); window.location.href='/controllers/procedures/index.php';</script>";
}
