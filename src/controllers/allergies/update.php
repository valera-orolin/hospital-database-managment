<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$allergyid = $_POST['allergyid'];
$code = $_POST['code'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';

if (!empty($code) && !empty($name) && !empty($description)) {
    $query = "UPDATE allergy SET code = ?, name = ?, description = ? WHERE allergyid = ?";
    $params = [$code, $name, $description, $allergyid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/allergies/index.php");
            exit();
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/allergies/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to update the record. Code, Name and Description cannot be empty.'); window.location.href='/controllers/allergies/index.php';</script>";
    exit();
}
