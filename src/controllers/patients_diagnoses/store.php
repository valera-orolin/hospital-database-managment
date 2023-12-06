<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'] ?? '';
$diagnosis = $_POST['diagnosis'] ?? '';
$date_diagnosed = $_POST['date_diagnosed'] ?? '';

if (!empty($patient) && !empty($diagnosis) && !empty($date_diagnosed)) {
    
    $existingRecord = executeQuery("SELECT * FROM patient_diagnosis WHERE patient = ? AND diagnosis = ?", [$patient, $diagnosis]);
    
    if (empty($existingRecord)) {
        $query = "INSERT INTO patient_diagnosis (patient, diagnosis, date_diagnosed) VALUES (?, ?, ?)";
        $params = [$patient, $diagnosis, $date_diagnosed];

        try {
            $executionResult = executeQuery($query, $params);
            if ($executionResult) {
                header("Location: /controllers/patients_diagnoses/index.php");
                exit();
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/patients_diagnoses/index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Failed to create a record. The combination of Patient and Diagnosis already exists.'); window.location.href='/controllers/patients_diagnoses/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to create a record. Patient, Diagnosis and Date Diagnosed cannot be empty.'); window.location.href='/controllers/patients_diagnoses/index.php';</script>";
    exit();
}
