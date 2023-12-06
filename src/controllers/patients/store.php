<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$personalnumber = $_POST['personalnumber'] ?? '';
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';

if (!empty($personalnumber) && !empty($name) && !empty($address) && !empty($phone)) {
    $query = "INSERT INTO patient (personalnumber, name, address, phone) VALUES (?, ?, ?, ?)";
    $params = [$personalnumber, $name, $address, $phone];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/patients/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/patients/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Personal Number, Name, Address and Phone cannot be empty.'); window.location.href='/controllers/patients/index.php';</script>";
}
