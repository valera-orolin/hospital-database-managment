<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctorId = $_POST['doctor'];
$departmentId = $_POST['department'];

$query = "DELETE FROM affiliation WHERE doctor = ? AND department = ?";
$params = [$doctorId, $departmentId];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/affiliations/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/affiliations/index.php';</script>";
}
