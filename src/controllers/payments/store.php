<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$bill = $_POST['bill'] ?? '';
$date_paid = $_POST['date_paid'] ?? '';
$amount = $_POST['amount'] ?? '';

if (!empty($bill) && !empty($date_paid) && !empty($amount)) {
    $query = "INSERT INTO payment (bill, date_paid, amount) VALUES (?, ?, ?)";
    $params = [$bill, $date_paid, $amount];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/payments/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/payments/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Bill, Date Paid and Amount cannot be empty.'); window.location.href='/controllers/payments/index.php';</script>";
}
