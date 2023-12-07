<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$hospitalizationid = $_POST['hospitalizationid'];

$query = "DELETE FROM hospitalization WHERE hospitalizationid = ?";
$params = [$hospitalizationid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/hospitalizations/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/hospitalizations/index.php';</script>";
}
