<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'] ?? '';
$doctor = $_POST['doctor'] ?? '';
$nurse = $_POST['nurse'] ?? '';
$procedure = $_POST['procedure'] ?? '';
$hospitalization = $_POST['hospitalization'] ?? '';
$date = $_POST['date'] ?? '';

if (!empty($patient) && !empty($doctor) && !empty($nurse) && !empty($procedure) && !empty($hospitalization) && !empty($date)) {
    
    $existingRecord = executeQuery("SELECT * FROM treatment WHERE patient = ? AND doctor = ? AND nurse = ? AND `procedure` = ? AND hospitalization = ? AND date = ?", [$patient, $doctor, $nurse, $procedure, $hospitalization, $date]);
    
    if (empty($existingRecord)) {
        $query = "INSERT INTO treatment (patient, doctor, nurse, `procedure`, hospitalization, date) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$patient, $doctor, $nurse, $procedure, $hospitalization, $date];

        try {
            $executionResult = executeQuery($query, $params);
            if ($executionResult) {
                header("Location: /controllers/treatments/index.php");
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/treatments/index.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to create a record. The combination of Patient, Doctor, Nurse, Procedure, Hospitalization and Date already exists.'); window.location.href='/controllers/treatments/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Patient, Doctor, Nurse, Procedure, Hospitalization and Date cannot be empty.'); window.location.href='/controllers/treatments/index.php';</script>";
}
