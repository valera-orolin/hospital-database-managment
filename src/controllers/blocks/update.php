<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$blockid = $_POST['blockid'];
$blockletter = $_POST['blockletter'] ?? '';
$floor = $_POST['floor'] ?? '';

if (!empty($blockid) && !empty($blockletter) && !empty($floor)) {
    $query = "UPDATE block SET blockletter = ?, floor = ? WHERE blockid = ?";
    $params = [$blockletter, $floor, $blockid];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/blocks/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/blocks/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Block ID, Block Letter and Floor cannot be empty.'); window.location.href='/controllers/blocks/index.php';</script>";
}
?>
