<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$departmentid = $_POST['departmentid'];

$query = "DELETE FROM department WHERE departmentid = ?";
$params = [$departmentid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/departments/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/departments/index.php';</script>";
}
