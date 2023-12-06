<?php
require '../../models/db_functions.php';

$diagnosisid = $_POST['diagnosisid'];

$query = "DELETE FROM diagnosis WHERE diagnosisid = ?";
$params = [$diagnosisid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/diagnoses/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/diagnoses/index.php';</script>";
}
