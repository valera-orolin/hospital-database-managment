<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$nurse = $_GET['nurse'] ?? '';
$block = $_GET['block'] ?? '';
$dt_time_start = $_GET['dt_time_start'] ?? '';
$dt_time_end = $_GET['dt_time_end'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM duty WHERE nurse IN (SELECT nurseid FROM nurse WHERE name LIKE ?) AND block LIKE ?";
$params = ['%' . $nurse . '%', '%' . $block . '%'];

if (!empty($dt_time_start) && !empty($dt_time_end)) {
    $query .= " AND dt_time_start >= ? AND dt_time_end <= ?";
    $params[] = $dt_time_start;
    $params[] = $dt_time_end;
}

if (!empty($sort)) {
    if ($sort == 'nurse') {
        $query .= " ORDER BY (SELECT name FROM nurse WHERE nurseid = duty.nurse) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
}

$duties = executeQuery($query, $params);

foreach ($duties as &$duty) {
    
    $nurse = executeQuery("SELECT name FROM nurse WHERE nurseid = ?", [$duty['nurse']]);
    $duty['link-nurse'] = [
        'url' => "/controllers/nurses/index.php?nurseid=" . $duty['nurse'],
        'text' => $nurse[0]['name']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('duties.index', ['duties' => $duties])->render();
