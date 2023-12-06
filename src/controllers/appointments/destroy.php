<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$appointmentid = $_POST['appointmentid'];

$query = "DELETE FROM appointment WHERE appointmentid = ?";
$params = [$appointmentid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/appointments/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/appointments/index.php';</script>";
}
