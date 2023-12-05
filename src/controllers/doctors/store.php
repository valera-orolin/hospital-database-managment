<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$personalnumber = $_POST['personalnumber'] ?? '';
$name = $_POST['name'] ?? '';
$position = $_POST['position'] ?? '';

if (!empty($personalnumber) && !empty($name) && !empty($position)) {
    $query = "INSERT INTO doctor (personalnumber, name, position) VALUES (?, ?, ?)";
    $params = [$personalnumber, $name, $position];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/doctors/index.php");
        } else {
            throw new Exception('Failed to create an object.');
        }
    } catch (Exception $e) {
        header("Location: /controllers/doctors/index.php");
    }
} else {
    echo "<script>alert('Failed to create an object.'); window.location.href='/controllers/doctors/index.php';</script>";
}