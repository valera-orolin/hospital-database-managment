<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$personalnumber = $_GET['personalnumber'] ?? '';
$name = $_GET['name'] ?? '';
$address = $_GET['address'] ?? '';
$phone = $_GET['phone'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM patient WHERE name LIKE ? AND address LIKE ? AND phone LIKE ?";
$params = ['%' . $name . '%', '%' . $address . '%', '%' . $phone . '%'];

if (!empty($personalnumber)) {
    $query .= " AND personalnumber = ?";
    $params[] = $personalnumber;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$patients = executeQuery($query, $params);

foreach ($patients as &$patient) {

    $patient['link-diagnoses'] = [
        'url' => "/controllers/diagnoses/index.php?patient=" . $patient['personalnumber'],
        'text' => "Diagnoses"
    ];

    $patient['link-allergies'] = [
        'url' => "/controllers/allergies/index.php?patient=" . $patient['personalnumber'],
        'text' => "Allergies"
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('patients.index', ['patients' => $patients])->render();