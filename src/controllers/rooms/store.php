<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$roomnumber = $_POST['roomnumber'] ?? '';
$roomtype = $_POST['roomtype'] ?? '';
$block = $_POST['block'] ?? '';
$isavailable = $_POST['isavailable'] ?? '';

if (!empty($roomnumber) && !empty($roomtype) && !empty($block) && !empty($isavailable)) {
    
    $existingRecord = executeQuery("SELECT * FROM room WHERE roomnumber = ?", [$roomnumber]);
    
    if (empty($existingRecord)) {
        $query = "INSERT INTO room (roomnumber, roomtype, block, isavailable) VALUES (?, ?, ?, ?)";
        $params = [$roomnumber, $roomtype, $block, $isavailable];

        try {
            $executionResult = executeQuery($query, $params);
            if ($executionResult) {
                header("Location: /controllers/rooms/index.php");
                exit();
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/rooms/index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Failed to create a record. The Room Number already exists.'); window.location.href='/controllers/rooms/index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Failed to create a record. Room Number, Room Type, Block and Is Available cannot be empty.'); window.location.href='/controllers/rooms/index.php';</script>";
    exit();
}
