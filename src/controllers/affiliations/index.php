<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$doctor = $_GET['doctor'] ?? '';
$department = $_GET['department'] ?? '';
$isaffiliationprimary = $_GET['isaffiliationprimary'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM affiliation WHERE doctor IN (SELECT doctorid FROM doctor WHERE name LIKE ?) AND department IN (SELECT departmentid FROM department WHERE name LIKE ?)";
$params = ['%' . $doctor . '%', '%' . $department . '%'];

if (!empty($isaffiliationprimary)) {
    $query .= " AND isaffiliationprimary = ?";
    $params[] = $isaffiliationprimary;
}

if (!empty($sort)) {
    if ($sort == 'doctor') {
        $query .= " ORDER BY (SELECT name FROM doctor WHERE doctorid = affiliation.doctor) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    } elseif ($sort == 'department') {
        $query .= " ORDER BY (SELECT name FROM department WHERE departmentid = affiliation.department) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
}

$affiliations = executeQuery($query, $params);

foreach ($affiliations as &$affiliation) {
    
    $doctor = executeQuery("SELECT name FROM doctor WHERE doctorid = ?", [$affiliation['doctor']]);
    $affiliation['link-doctor'] = [
        'url' => "/controllers/doctors/index.php?doctorid=" . $affiliation['doctor'],
        'text' => $doctor[0]['name']
    ];
    
    $department = executeQuery("SELECT name FROM department WHERE departmentid = ?", [$affiliation['department']]);
    $affiliation['link-department'] = [
        'url' => "/controllers/departments/index.php?departmentid=" . $affiliation['department'],
        'text' => $department[0]['name']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('affiliations.index', ['affiliations' => $affiliations])->render();
