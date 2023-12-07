<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$billid = $_POST['billid'];
$patient = $_POST['patient'] ?? '';
$date_issued = $_POST['date_issued'] ?? '';
$total_cost = $_POST['total_cost'] ?? '';

if (!empty($patient) && !empty($date_issued) && !empty($total_cost)) {
    $query = "UPDATE bill SET patient = ?, date_issued = ?, total_cost = ? WHERE billid = ?";
    $params = [$patient, $date_issued, $total_cost, $billid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/bills/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/bills/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Patient, Date Issued and Total Cost cannot be empty.'); window.location.href='/controllers/bills/index.php';</script>";
}
