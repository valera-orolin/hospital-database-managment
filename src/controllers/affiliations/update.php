<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctorId = $_POST['doctor'];
$departmentId = $_POST['department'];
$isaffiliationprimary = $_POST['isaffiliationprimary'] ?? '';

if (!empty($doctorId) && !empty($departmentId)) {
    $query = "UPDATE affiliation SET isaffiliationprimary = ? WHERE doctor = ? AND department = ?";
    $params = [$isaffiliationprimary, $doctorId, $departmentId];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/affiliations/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/affiliations/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Doctor and Department cannot be empty.'); window.location.href='/controllers/affiliations/index.php';</script>";
}
