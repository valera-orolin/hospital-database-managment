<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$paymentid = $_POST['paymentid'];
$bill = $_POST['bill'] ?? '';
$date_paid = $_POST['date_paid'] ?? '';
$amount = $_POST['amount'] ?? '';

if (!empty($bill) && !empty($date_paid) && !empty($amount)) {
    $query = "UPDATE payment SET bill = ?, date_paid = ?, amount = ? WHERE paymentid = ?";
    $params = [$bill, $date_paid, $amount, $paymentid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/payments/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/payments/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Bill, Date Paid and Amount cannot be empty.'); window.location.href='/controllers/payments/index.php';</script>";
}
