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

$query = "SELECT * FROM doctor WHERE personalnumber LIKE ? AND name LIKE ? AND position LIKE ?";
$params = ['%' . $personalnumber . '%', '%' . $name . '%', '%' . $position . '%'];

if (!empty($doctorid)) {
    $query .= " AND doctorid = ?";
    $params[] = $doctorid;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$doctors = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('doctors.index', ['doctors' => $doctors])->render();
