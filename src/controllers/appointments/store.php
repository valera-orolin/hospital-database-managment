<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'] ?? '';
$doctorId = $_POST['doctor'] ?? '';
$nurseId = $_POST['nurse'] ?? '';
$examinationroom = $_POST['examinationroom'] ?? '';
$dt_time_start = $_POST['dt_time_start'] ?? '';
$dt_time_end = $_POST['dt_time_end'] ?? '';

if (!empty($patient) && !empty($doctorId) && !empty($nurseId) && !empty($examinationroom) && !empty($dt_time_start) && !empty($dt_time_end)) {
    $query = "INSERT INTO appointment (patient, doctor, nurse, examinationroom, dt_time_start, dt_time_end) VALUES (?, ?, ?, ?, ?, ?)";
    $params = [$patient, $doctorId, $nurseId, $examinationroom, $dt_time_start, $dt_time_end];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/appointments/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/appointments/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Patient, Doctor, Nurse, Examination Room, Appointment Start Time and Appointment End Time cannot be empty.'); window.location.href='/controllers/appointments/index.php';</script>";
}
