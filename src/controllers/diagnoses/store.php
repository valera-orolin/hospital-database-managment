<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$code = $_POST['code'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';

if (!empty($code) && !empty($name) && !empty($description)) {
    $query = "INSERT INTO diagnosis (code, name, description) VALUES (?, ?, ?)";
    $params = [$code, $name, $description];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/diagnoses/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/diagnoses/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Code, Name and Description cannot be empty.'); window.location.href='/controllers/diagnoses/index.php';</script>";
}
