<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$allergyid = $_GET['allergyid'] ?? '';
$code = $_GET['code'] ?? '';
$name = $_GET['name'] ?? '';
$patient = $_GET['patient'] ?? '';
$description = $_GET['description'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM allergy WHERE name LIKE ? AND description LIKE ?";
$params = ['%' . $name . '%', '%' . $description . '%'];

if (!empty($allergyid)) {
    $query .= " AND allergyid = ?";
    $params[] = $allergyid;
}

if (!empty($patient)) {
    $query .= " AND allergyid IN (SELECT allergy FROM patient_allergy WHERE patient = ?)";
    $params[] = $patient;
}

if (!empty($code)) {
    $query .= " AND code LIKE ?";
    $params[] = '%' . $code . '%';
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$allergies = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('allergies.index', ['allergies' => $allergies])->render();
?>
