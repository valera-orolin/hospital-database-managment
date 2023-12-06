<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctorId = $_POST['doctor'];
$procedureId = $_POST['procedure'];

$query = "DELETE FROM certification WHERE doctor = ? AND `procedure` = ?";
$params = [$doctorId, $procedureId];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controllers/certifications/index.php");
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    echo "<script>alert('Failed to delete the record.'); window.location.href='/controllers/certifications/index.php';</script>";
}
