<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$nurseid = $_GET['nurseid'] ?? '';
$name = $_GET['name'] ?? '';
$position = $_GET['position'] ?? '';
$personalnumber = $_GET['personalnumber'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM nurse WHERE name LIKE ? AND position LIKE ? AND personalnumber LIKE ?";
$params = ['%' . $name . '%', '%' . $position . '%', '%' . $personalnumber . '%'];

if (!empty($nurseid)) {
    $query .= " AND nurseid = ?";
    $params[] = $nurseid;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$nurses = executeQuery($query, $params);

foreach ($nurses as &$nurse) { 
    $nurse['link-duties'] = [
        'url' => "/controllers/duties/index.php?nurseid=" . $nurse['nurseid'],
        'text' => "Duties"
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('nurses.index', ['nurses' => $nurses])->render();