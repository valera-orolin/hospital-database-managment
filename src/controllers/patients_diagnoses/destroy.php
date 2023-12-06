<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'];
$diagnosis = $_POST['diagnosis'];

$query = "DELETE FROM patient_diagnosis WHERE patient = ? AND diagnosis = ?";
$params = [$patient, $diagnosis];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/patients_diagnoses/index.php");
        exit();
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/patients_diagnoses/index.php';</script>";
    exit();
}
