<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctor = $_POST['doctor'];
$patient = $_POST['patient'];
$medication = $_POST['medication'];
$date = $_POST['date'] ?? '';
$description = $_POST['description'] ?? '';

if (!empty($doctor) && !empty($patient) && !empty($medication) && !empty($date) && !empty($description)) {
    
    $existingRecord = executeQuery("SELECT * FROM prescription WHERE doctor = ? AND patient = ? AND medication = ? AND date = ?", [$doctor, $patient, $medication, $date]);
    
    if (!empty($existingRecord)) {
        $query = "UPDATE prescription SET description = ? WHERE doctor = ? AND patient = ? AND medication = ? AND date = ?";
        $params = [$description, $doctor, $patient, $medication, $date];

        try {
            $executionResult = executeQuery($query, $params);
            if ($executionResult) {
                header("Location: /controllers/prescriptions/index.php");
                exit();
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/prescriptions/index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Failed to update the record. The combination of Doctor, Patient, Medication and Date does not exist.'); window.location.href='/controllers/prescriptions/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to update the record. Doctor, Patient, Medication, Date and Description cannot be empty.'); window.location.href='/controllers/prescriptions/index.php';</script>";
    exit();
}
