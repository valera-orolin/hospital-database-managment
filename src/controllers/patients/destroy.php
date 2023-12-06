<?php
require '../../models/db_functions.php';

$personalnumber = $_POST['personalnumber'];

$query = "DELETE FROM patient WHERE personalnumber = ?";
$params = [$personalnumber];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/patients/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/patients/index.php';</script>";
}
