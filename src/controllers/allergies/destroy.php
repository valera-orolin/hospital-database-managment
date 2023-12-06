<?php
require '../../models/db_functions.php';

$allergyid = $_POST['allergyid'];

$query = "DELETE FROM allergy WHERE allergyid = ?";
$params = [$allergyid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/allergies/index.php");
        exit();
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/allergies/index.php';</script>";
    exit();
}
