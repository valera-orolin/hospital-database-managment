<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$patient = $_GET['patient'] ?? '';
$diagnosis = $_GET['diagnosis'] ?? '';
$date_diagnosed = $_GET['date_diagnosed'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM patient_diagnosis WHERE patient LIKE ? AND diagnosis LIKE ? AND date_diagnosed LIKE ?";
$params = ['%' . $patient . '%', '%' . $diagnosis . '%', '%' . $date_diagnosed . '%'];

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$patients_diagnoses = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('patients_diagnoses.index', ['patients_diagnoses' => $patients_diagnoses])->render();
