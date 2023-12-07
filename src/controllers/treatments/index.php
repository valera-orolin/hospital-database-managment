<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$patient = $_GET['patient'] ?? '';
$doctor = $_GET['doctor'] ?? '';
$nurse = $_GET['nurse'] ?? '';
$procedure = $_GET['procedure'] ?? '';
$hospitalization = $_GET['hospitalization'] ?? '';
$date = $_GET['date'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM treatment WHERE patient IN (SELECT personalnumber FROM patient WHERE name LIKE ?) AND doctor IN (SELECT doctorid FROM doctor WHERE name LIKE ?) AND nurse IN (SELECT nurseid FROM nurse WHERE name LIKE ?) AND `procedure` IN (SELECT procedureid FROM `procedure` WHERE name LIKE ?) AND hospitalization LIKE ?";
$params = ['%' . $patient . '%', '%' . $doctor . '%', '%' . $nurse . '%', '%' . $procedure . '%', '%' . $hospitalization . '%'];

if (!empty($date)) {
    $query .= " AND date = ?";
    $params[] = $date;
}

if (!empty($sort)) {
    if ($sort == 'doctor') {
        $query .= " ORDER BY (SELECT name FROM doctor WHERE doctorid = treatment.doctor) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    } elseif ($sort == 'nurse') {
        $query .= " ORDER BY (SELECT name FROM nurse WHERE nurseid = treatment.nurse) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    } elseif ($sort == 'patient') {
        $query .= " ORDER BY (SELECT name FROM patient WHERE personalnumber = treatment.patient) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }    
}

$treatments = executeQuery($query, $params);

foreach ($treatments as &$treatment) {

    $patient = executeQuery("SELECT name FROM patient WHERE personalnumber = ?", [$treatment['patient']]);
    $treatment['link-patient'] = [
        'url' => "/controllers/patients/index.php?personalnumber=" . $treatment['patient'],
        'text' => $patient[0]['name']
    ];
    
    $doctor = executeQuery("SELECT name FROM doctor WHERE doctorid = ?", [$treatment['doctor']]);
    $treatment['link-doctor'] = [
        'url' => "/controllers/doctors/index.php?doctorid=" . $treatment['doctor'],
        'text' => $doctor[0]['name']
    ];
    
    $nurse = executeQuery("SELECT name FROM nurse WHERE nurseid = ?", [$treatment['nurse']]);
    $treatment['link-nurse'] = [
        'url' => "/controllers/nurses/index.php?nurseid=" . $treatment['nurse'],
        'text' => $nurse[0]['name']
    ];
    
    $procedure = executeQuery("SELECT name FROM `procedure` WHERE procedureid = ?", [$treatment['procedure']]);
    $treatment['link-procedure'] = [
        'url' => "/controllers/procedures/index.php?procedureid=" . $treatment['procedure'],
        'text' => $procedure[0]['name']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('treatments.index', ['treatments' => $treatments])->render();
