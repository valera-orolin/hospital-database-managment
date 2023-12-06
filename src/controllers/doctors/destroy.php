<?php
require '../../models/db_functions.php';

$doctorid = $_POST['doctorid'];

$query = "DELETE FROM doctor WHERE doctorid = ?";
$params = [$doctorid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/doctors/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/doctors/index.php';</script>";
}
