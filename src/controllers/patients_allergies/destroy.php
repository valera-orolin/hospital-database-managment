<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'];
$allergy = $_POST['allergy'];

$query = "DELETE FROM patient_allergy WHERE patient = ? AND allergy = ?";
$params = [$patient, $allergy];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/patients_allergies/index.php");
        exit();
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/patients_allergies/index.php';</script>";
    exit();
}
