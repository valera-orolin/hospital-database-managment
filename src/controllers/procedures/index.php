<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$procedureid = $_GET['procedureid'] ?? '';
$code = $_GET['code'] ?? '';
$name = $_GET['name'] ?? '';
$cost = $_GET['cost'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM `procedure` WHERE code LIKE ? AND name LIKE ? AND cost LIKE ?";
$params = ['%' . $code . '%', '%' . $name . '%', '%' . $cost . '%'];

if (!empty($procedureid)) {
    $query .= " AND procedureid = ?";
    $params[] = $procedureid;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$procedures = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('procedures.index', ['procedures' => $procedures])->render();
