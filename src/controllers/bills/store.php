<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'] ?? '';
$date_issued = $_POST['date_issued'] ?? '';
$total_cost = $_POST['total_cost'] ?? '';

if (!empty($patient) && !empty($date_issued) && !empty($total_cost)) {
    $query = "INSERT INTO bill (patient, date_issued, total_cost) VALUES (?, ?, ?)";
    $params = [$patient, $date_issued, $total_cost];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/bills/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/bills/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Patient, Date Issued and Total Cost cannot be empty.'); window.location.href='/controllers/bills/index.php';</script>";
}
