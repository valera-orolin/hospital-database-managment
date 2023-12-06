<?php
require '../../models/db_functions.php';

$nurseid = $_POST['nurseid'];

$query = "DELETE FROM nurse WHERE nurseid = ?";
$params = [$nurseid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/nurses/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/nurses/index.php';</script>";
}
