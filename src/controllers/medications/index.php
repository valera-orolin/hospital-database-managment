<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$medicationid = $_GET['medicationid'] ?? '';
$code = $_GET['code'] ?? '';
$name = $_GET['name'] ?? '';
$brand = $_GET['brand'] ?? '';
$description = $_GET['description'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM medication WHERE code LIKE ? AND name LIKE ? AND brand LIKE ? AND description LIKE ?";
$params = ['%' . $code . '%', '%' . $name . '%', '%' . $brand . '%', '%' . $description . '%'];

if (!empty($medicationid)) {
    $query .= " AND medicationid = ?";
    $params[] = $medicationid;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$medications = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('medications.index', ['medications' => $medications])->render();
