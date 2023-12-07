<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$nurseId = $_POST['nurse'] ?? '';
$blockId = $_POST['block'] ?? '';
$dt_time_start = $_POST['dt_time_start'] ?? '';
$dt_time_end = $_POST['dt_time_end'] ?? '';

if (!empty($nurseId) && !empty($blockId) && !empty($dt_time_start) && !empty($dt_time_end)) {
    $query = "INSERT INTO duty (nurse, block, dt_time_start, dt_time_end) VALUES (?, ?, ?, ?)";
    $params = [$nurseId, $blockId, $dt_time_start, $dt_time_end];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/duties/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/duties/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Nurse, Block, Start Time and End Time cannot be empty.'); window.location.href='/controllers/duties/index.php';</script>";
}
