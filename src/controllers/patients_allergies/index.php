<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$patient = $_GET['patient'] ?? '';
$allergy = $_GET['allergy'] ?? '';
$date_diagnosed = $_GET['date_diagnosed'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM patient_allergy WHERE patient LIKE ? AND allergy LIKE ? AND date_diagnosed LIKE ?";
$params = ['%' . $patient . '%', '%' . $allergy . '%', '%' . $date_diagnosed . '%'];

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$patients_allergies = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('patients_allergies.index', ['patients_allergies' => $patients_allergies])->render();
