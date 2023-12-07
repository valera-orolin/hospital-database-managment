<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$nurseId = $_POST['nurse'];
$blockId = $_POST['block'];
$dt_time_start = $_POST['dt_time_start'];
$dt_time_end = $_POST['dt_time_end'];

$query = "DELETE FROM duty WHERE nurse = ? AND block = ? AND dt_time_start = ? AND dt_time_end = ?";
$params = [$nurseId, $blockId, $dt_time_start, $dt_time_end];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/duties/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/duties/index.php';</script>";
}
