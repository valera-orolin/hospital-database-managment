<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$roomnumber = $_POST['roomnumber'];
$roomtype = $_POST['roomtype'] ?? '';
$block = $_POST['block'] ?? '';
$isavailable = $_POST['isavailable'] ?? '';

if (!empty($roomnumber) && !empty($roomtype) && !empty($block)) {
    $query = "UPDATE room SET roomtype = ?, block = ?, isavailable = ? WHERE roomnumber = ?";
    $params = [$roomtype, $block, $isavailable, $roomnumber];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/rooms/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/rooms/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Room Number, Room Type, Block and Is Available cannot be empty.'); window.location.href='/controllers/rooms/index.php';</script>";
}
