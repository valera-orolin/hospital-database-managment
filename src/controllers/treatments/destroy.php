<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$patient = $_POST['patient'];
$procedure = $_POST['procedure'];
$hospitalization = $_POST['hospitalization'];
$date = $_POST['date'];

$query = "DELETE FROM treatment WHERE patient = ? AND `procedure` = ? AND hospitalization = ? AND date = ?";
$params = [$patient, $procedure, $hospitalization, $date];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/treatments/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/treatments/index.php';</script>";
}
