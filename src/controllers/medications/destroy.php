<?php
require '../../models/db_functions.php';

$medicationid = $_POST['medicationid'];

$query = "DELETE FROM `medication` WHERE medicationid = ?";
$params = [$medicationid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/medications/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/medications/index.php';</script>";
}
