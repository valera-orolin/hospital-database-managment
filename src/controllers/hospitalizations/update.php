<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$hospitalizationid = $_POST['hospitalizationid'];
$patient = $_POST['patient'] ?? '';
$room = $_POST['room'] ?? '';
$dt_time_start = $_POST['dt_time_start'] ?? '';
$dt_time_end = $_POST['dt_time_end'] ?? '';

if (!empty($patient) && !empty($room) && !empty($dt_time_start) && !empty($dt_time_end)) {
    $query = "UPDATE hospitalization SET patient = ?, room = ?, dt_time_start = ?, dt_time_end = ? WHERE hospitalizationid = ?";
    $params = [$patient, $room, $dt_time_start, $dt_time_end, $hospitalizationid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/hospitalizations/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/hospitalizations/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Patient, Room, Start Time and End Time cannot be empty.'); window.location.href='/controllers/hospitalizations/index.php';</script>";
}
