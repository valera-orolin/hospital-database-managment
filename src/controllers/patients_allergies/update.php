<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'];
$allergy = $_POST['allergy'];
$date_diagnosed = $_POST['date_diagnosed'] ?? '';

if (!empty($patient) && !empty($allergy) && !empty($date_diagnosed)) {
    $query = "UPDATE patient_allergy SET date_diagnosed = ? WHERE patient = ? AND allergy = ?";
    $params = [$date_diagnosed, $patient, $allergy];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/patients_allergies/index.php");
            exit();
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/patients_allergies/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to update the record. Patient, Allergy and Date Diagnosed cannot be empty.'); window.location.href='/controllers/patients_allergies/index.php';</script>";
    exit();
}
