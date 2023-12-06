<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctorId = $_POST['doctor'];
$procedureId = $_POST['procedure'];
$date_certificationstart = $_POST['date_certificationstart'] ?? '';
$date_certificationend = $_POST['date_certificationend'] ?? '';

if (!empty($doctorId) && !empty($procedureId) && !empty($date_certificationstart) && !empty($date_certificationend)) {
    $query = "UPDATE certification SET date_certificationstart = ?, date_certificationend = ? WHERE doctor = ? AND `procedure` = ?";
    $params = [$date_certificationstart, $date_certificationend, $doctorId, $procedureId];

    try {
        $executionResult = executeQuery($query, $params);
        if ($executionResult) {
            header("Location: /controllers/certifications/index.php");
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo "<script>alert('Failed to update the record.'); window.location.href='/controllers/certifications/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to update the record. Doctor, Procedure, Certification Start Date and Certification End Date cannot be empty.'); window.location.href='/controllers/certifications/index.php';</script>";
}
