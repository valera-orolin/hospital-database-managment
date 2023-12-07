<?php
require '../../models/db_functions.php';

$blockid = $_POST['blockid'];

$query = "DELETE FROM block WHERE blockid = ?";
$params = [$blockid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/blocks/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/blocks/index.php';</script>";
}
