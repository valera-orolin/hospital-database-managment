<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';

$doctorId = $_POST['doctor'] ?? '';
$procedureId = $_POST['procedure'] ?? '';
$date_certificationstart = $_POST['date_certificationstart'] ?? '';
$date_certificationend = $_POST['date_certificationend'] ?? '';

if (!empty($doctorId) && !empty($procedureId) && !empty($date_certificationstart) && !empty($date_certificationend)) {
    
    $existingRecord = executeQuery("SELECT * FROM certification WHERE doctor = ? AND `procedure` = ?", [$doctorId, $procedureId]);
    
    if (empty($existingRecord)) {
        $query = "INSERT INTO certification (doctor, procedure, date_certificationstart, date_certificationend) VALUES (?, ?, ?, ?)";
        $params = [$doctorId, $procedureId, $date_certificationstart, $date_certificationend];

        try {
            $executionResult = executeQuery($query, $params);
            if ($executionResult) {
                header("Location: /controllers/certifications/index.php");
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            echo "<script>alert('Failed to create a record.'); window.location.href='/controllers/certifications/index.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to create a record. The combination of Doctor and Procedure already exists.'); window.location.href='/controllers/certifications/index.php';</script>";
    }
} else {
    echo "<script>alert('Failed to create a record. Doctor, Procedure, Certification Start Date and Certification End Date cannot be empty.'); window.location.href='/controllers/certifications/index.php';</script>";
}
