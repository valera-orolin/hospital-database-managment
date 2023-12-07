<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctor = $_POST['doctor'];
$patient = $_POST['patient'];
$medication = $_POST['medication'];
$date = $_POST['date'];

$query = "DELETE FROM prescription WHERE doctor = ? AND patient = ? AND medication = ? AND date = ?";
$params = [$doctor, $patient, $medication, $date];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/prescriptions/index.php");
        exit();
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/prescriptions/index.php';</script>";
    exit();
}
