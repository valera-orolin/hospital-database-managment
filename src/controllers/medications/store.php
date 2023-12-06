<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$code = $_POST['code'] ?? '';
$name = $_POST['name'] ?? '';
$brand = $_POST['brand'] ?? '';
$description = $_POST['description'] ?? '';

if (!empty($code) && !empty($name) && !empty($brand) && !empty($description)) {
    $query = "INSERT INTO medication (code, name, brand, description) VALUES (?, ?, ?, ?)";
    $params = [$code, $name, $brand, $description];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/medications/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/medications/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Code, Name, Brand and Description cannot be empty.'); window.location.href='/controllers/medications/index.php';</script>";
}
