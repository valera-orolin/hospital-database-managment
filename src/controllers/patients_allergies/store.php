<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'] ?? '';
$allergy = $_POST['allergy'] ?? '';
$date_diagnosed = $_POST['date_diagnosed'] ?? '';

if (!empty($patient) && !empty($allergy) && !empty($date_diagnosed)) {
    
    $existingRecord = executeQuery("SELECT * FROM patient_allergy WHERE patient = ? AND allergy = ?", [$patient, $allergy]);
    
    if (empty($existingRecord)) {
        $query = "INSERT INTO patient_allergy (patient, allergy, date_diagnosed) VALUES (?, ?, ?)";
        $params = [$patient, $allergy, $date_diagnosed];

        try {
            $executionResult = executeQuery($query, $params);
            if ($executionResult) {
                header("Location: /controllers/patients_allergies/index.php");
                exit();
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/patients_allergies/index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Failed to create a record. The combination of Patient and Allergy already exists.'); window.location.href='/controllers/patients_allergies/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to create a record. Patient, Allergy and Date Diagnosed cannot be empty.'); window.location.href='/controllers/patients_allergies/index.php';</script>";
    exit();
}
