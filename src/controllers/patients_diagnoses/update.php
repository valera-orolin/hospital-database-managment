<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'];
$diagnosis = $_POST['diagnosis'];
$date_diagnosed = $_POST['date_diagnosed'] ?? '';

if (!empty($patient) && !empty($diagnosis) && !empty($date_diagnosed)) {
    $query = "UPDATE patient_diagnosis SET date_diagnosed = ? WHERE patient = ? AND diagnosis = ?";
    $params = [$date_diagnosed, $patient, $diagnosis];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/patients_diagnoses/index.php");
            exit();
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/patients_diagnoses/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to update the record. Patient, Diagnosis and Date Diagnosed cannot be empty.'); window.location.href='/controllers/patients_diagnoses/index.php';</script>";
    exit();
}
