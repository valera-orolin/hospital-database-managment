<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$diagnosisid = $_POST['diagnosisid'];
$code = $_POST['code'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';

if (!empty($code) && !empty($name) && !empty($description)) {
    $query = "UPDATE diagnosis SET code = ?, name = ?, description = ? WHERE diagnosisid = ?";
    $params = [$code, $name, $description, $diagnosisid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/diagnoses/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/diagnoses/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Code, Name and Description cannot be empty.'); window.location.href='/controllers/diagnoses/index.php';</script>";
}
