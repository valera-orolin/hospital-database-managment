<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$nurseid = $_POST['nurseid'];
$personalnumber = $_POST['personalnumber'] ?? '';
$name = $_POST['name'] ?? '';
$position = $_POST['position'] ?? '';

if (!empty($personalnumber) && !empty($name) && !empty($position)) {
    $query = "UPDATE nurse SET personalnumber = ?, name = ?, position = ? WHERE nurseid = ?";
    $params = [$personalnumber, $name, $position, $nurseid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/nurses/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/nurses/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Personal Number, Name and Position cannot be empty.'); window.location.href='/controllers/nurses/index.php';</script>";
}
