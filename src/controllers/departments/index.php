<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$departmentid = $_GET['departmentid'] ?? '';
$name = $_GET['name'] ?? '';
$head = $_GET['head'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM department WHERE name LIKE ? AND head IN (SELECT doctorid FROM doctor WHERE name LIKE ?)";
$params = ['%' . $name . '%', '%' . $head . '%'];

if (!empty($departmentid)) {
    $query .= " AND departmentid = ?";
    $params[] = $departmentid;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$departments = executeQuery($query, $params);

foreach ($departments as &$department) {
    $doctor = executeQuery("SELECT name FROM doctor WHERE doctorid = ?", [$department['head']]);
    $department['head'] = [
        'url' => "/controllers/doctors/index.php?doctorid=" . $department['head'],
        'text' => $doctor[0]['name']
    ];

    $department['doctors'] = [
        'url' => "/controllers/doctors/index.php?departmentid=" . $department['departmentid'],
        'text' => "Doctors"
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('departments.index', ['departments' => $departments])->render();