<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$paymentid = $_POST['paymentid'];

$query = "DELETE FROM payment WHERE paymentid = ?";
$params = [$paymentid];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/payments/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/payments/index.php';</script>";
}
