<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$doctorid = $_GET['doctorid'] ?? '';
$personalnumber = $_GET['personalnumber'] ?? '';
$name = $_GET['name'] ?? '';
$position = $_GET['position'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';
$departmentid = $_GET['departmentid'] ?? '';

$query = "SELECT * FROM doctor WHERE personalnumber LIKE ? AND name LIKE ? AND position LIKE ?";
$params = ['%' . $personalnumber . '%', '%' . $name . '%', '%' . $position . '%'];

if (!empty($doctorid)) {
    $query .= " AND doctorid = ?";
    $params[] = $doctorid;
}

if (!empty($departmentid)) {
    $query .= " AND doctorid IN (SELECT doctor FROM affiliation WHERE department = ?)";
    $params[] = $departmentid;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$doctors = executeQuery($query, $params);

foreach ($doctors as &$doctor) { 
    $doctor['link-appointments'] = [
        'url' => "/controllers/appointments/index.php?doctorid=" . $doctor['doctorid'],
        'text' => "Appointments"
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('doctors.index', ['doctors' => $doctors])->render();
