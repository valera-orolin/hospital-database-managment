<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$blockletter = $_POST['blockletter'] ?? '';
$floor = $_POST['floor'] ?? '';

if (!empty($blockletter) && !empty($floor)) {
    $query = "INSERT INTO block (blockletter, floor) VALUES (?, ?)";
    $params = [$blockletter, $floor];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/blocks/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/blocks/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Block ID, Block Letter and Floor cannot be empty.'); window.location.href='/controllers/blocks/index.php';</script>";
}
