<?php
require '../../models/db_functions.php';

$roomnumber = $_POST['roomnumber'];

$query = "DELETE FROM room WHERE roomnumber = ?";
$params = [$roomnumber];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/rooms/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/rooms/index.php';</script>";
}
