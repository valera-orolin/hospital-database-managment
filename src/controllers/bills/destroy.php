<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$billid = $_POST['billid'];

$query = "DELETE FROM bill WHERE billid = ?";
$params = [$billid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/bills/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/bills/index.php';</script>";
}
