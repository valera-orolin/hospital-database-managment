<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctor = $_POST['doctor'] ?? '';
$patient = $_POST['patient'] ?? '';
$medication = $_POST['medication'] ?? '';
$date = $_POST['date'] ?? '';
$description = $_POST['description'] ?? '';

if (!empty($doctor) && !empty($patient) && !empty($medication) && !empty($date) && !empty($description)) {
    
    $existingRecord = executeQuery("SELECT * FROM prescription WHERE doctor = ? AND patient = ? AND medication = ? AND date = ?", [$doctor, $patient, $medication, $date]);
    
    if (empty($existingRecord)) {
        $query = "INSERT INTO prescription (doctor, patient, medication, date, description) VALUES (?, ?, ?, ?, ?)";
        $params = [$doctor, $patient, $medication, $date, $description];

        try {
            $executionResult = executeQuery($query, $params);
            if ($executionResult) {
                header("Location: /controllers/prescriptions/index.php");
                exit();
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/prescriptions/index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Failed to create a record. The combination of Doctor, Patient, Medication and Date already exists.'); window.location.href='/controllers/prescriptions/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to create a record. Doctor, Patient, Medication, Date and Description cannot be empty.'); window.location.href='/controllers/prescriptions/index.php';</script>";
    exit();
}
