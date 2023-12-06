<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$patient = $_GET['patient'] ?? '';
$doctorName = $_GET['doctor'] ?? '';
$nurseName = $_GET['nurse'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM appointment WHERE patient LIKE ? AND doctor IN (SELECT doctorid FROM doctor WHERE name LIKE ?) AND nurse IN (SELECT nurseid FROM nurse WHERE name LIKE ?)";
$params = ['%' . $patient . '%', '%' . $doctorName . '%', '%' . $nurseName . '%'];

if (!empty($sort)) {
    if ($sort == 'doctor') {
        $query .= " ORDER BY (SELECT name FROM doctor WHERE doctorid = appointment.doctor) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    } elseif ($sort == 'nurse') {
        $query .= " ORDER BY (SELECT name FROM nurse WHERE nurseid = appointment.nurse) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
}

$appointments = executeQuery($query, $params);

foreach ($appointments as &$appointment) {
    
    $doctor = executeQuery("SELECT name FROM doctor WHERE doctorid = ?", [$appointment['doctor']]);
    $appointment['link-doctor'] = [
        'url' => "/controllers/doctors/index.php?doctorid=" . $appointment['doctor'],
        'text' => $doctor[0]['name']
    ];
    
    $nurse = executeQuery("SELECT name FROM nurse WHERE nurseid = ?", [$appointment['nurse']]);
    $appointment['link-nurse'] = [
        'url' => "/controllers/nurses/index.php?nurseid=" . $appointment['nurse'],
        'text' => $nurse[0]['name']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('appointments.index', ['appointments' => $appointments])->render();
