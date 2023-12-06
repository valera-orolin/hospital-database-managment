<?php
require '../../models/db_functions.php';

$procedureid = $_POST['procedureid'];

$query = "DELETE FROM `procedure` WHERE procedureid = ?";
$params = [$procedureid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/procedures/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/procedures/index.php';</script>";
}
