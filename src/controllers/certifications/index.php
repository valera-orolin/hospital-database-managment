<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$doctorName = $_GET['doctor'] ?? '';
$procedureName = $_GET['procedure'] ?? '';
$date_certificationstart = $_GET['date_certificationstart'] ?? '';
$date_certificationend = $_GET['date_certificationend'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM certification WHERE doctor IN (SELECT doctorid FROM doctor WHERE name LIKE ?) AND `procedure` IN (SELECT procedureid FROM `procedure` WHERE name LIKE ?)";
$params = ['%' . $doctorName . '%', '%' . $procedureName . '%'];

if (!empty($date_certificationstart) && !empty($date_certificationend)) {
    $query .= " AND date_certificationstart >= ? AND date_certificationend <= ?";
    $params[] = $date_certificationstart;
    $params[] = $date_certificationend;
}

if (!empty($sort)) {
    if ($sort == 'doctor') {
        $query .= " ORDER BY (SELECT name FROM doctor WHERE doctorid = certification.doctor) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    } elseif ($sort == 'procedure') {
        $query .= " ORDER BY (SELECT name FROM `procedure` WHERE procedureid = certification.procedure) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
}

$certifications = executeQuery($query, $params);

foreach ($certifications as &$certification) {
    
    $doctor = executeQuery("SELECT name FROM doctor WHERE doctorid = ?", [$certification['doctor']]);
    $certification['link-doctor'] = [
        'url' => "/controllers/doctors/index.php?doctorid=" . $certification['doctor'],
        'text' => $doctor[0]['name']
    ];
    

    $procedure = executeQuery("SELECT name FROM `procedure` WHERE procedureid = ?", [$certification['procedure']]);
    $certification['link-procedure'] = [
        'url' => "/controllers/procedures/index.php?procedureid=" . $certification['procedure'],
        'text' => $procedure[0]['name']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('certifications.index', ['certifications' => $certifications])->render();
