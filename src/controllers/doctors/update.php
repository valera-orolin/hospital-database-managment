<?php
require '../../models/db_functions.php';

$doctorid = $_POST['doctorid'];
$personalnumber = $_POST['personalnumber'];
$name = $_POST['name'];
$position = $_POST['position'];

$query = "UPDATE doctor SET personalnumber = ?, name = ?, position = ? WHERE doctorid = ?";
$params = [$personalnumber, $name, $position, $doctorid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/doctors/index.php");
    } else {
        throw new Exception('Failed to update the record.');
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/doctors/index.php';</script>";
}
