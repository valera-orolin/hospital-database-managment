<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$diagnosisid = $_GET['diagnosisid'] ?? '';
$code = $_GET['code'] ?? '';
$name = $_GET['name'] ?? '';
$description = $_GET['description'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM diagnosis WHERE code LIKE ? AND name LIKE ? AND description LIKE ?";
$params = ['%' . $code . '%', '%' . $name . '%', '%' . $description . '%'];

if (!empty($diagnosisid)) {
    $query .= " AND diagnosisid = ?";
    $params[] = $diagnosisid;
}

if (!empty($code)) {
    $query .= " AND code LIKE ?";
    $params[] = '%' . $code . '%';
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$diagnoses = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('diagnoses.index', ['diagnoses' => $diagnoses])->render();
