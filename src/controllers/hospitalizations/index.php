<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$patient = $_GET['patient'] ?? '';
$room = $_GET['room'] ?? '';
$dt_time_start = $_GET['dt_time_start'] ?? '';
$dt_time_end = $_GET['dt_time_end'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM hospitalization WHERE patient LIKE ? AND room LIKE ?";
$params = ['%' . $patient . '%', '%' . $room . '%'];

if (!empty($dt_time_start) && !empty($dt_time_end)) {
    $query .= " AND dt_time_start >= ? AND dt_time_end <= ?";
    $params[] = $dt_time_start;
    $params[] = $dt_time_end;
}

if (!empty($sort)) {
    if ($sort == 'patient') {
        $query .= " ORDER BY patient " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
    if ($sort == 'room') {
        $query .= " ORDER BY room " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
}

$hospitalizations = executeQuery($query, $params);

foreach ($hospitalizations as &$hospitalization) {
    $patient = executeQuery("SELECT name FROM patient WHERE personalnumber = ?", [$hospitalization['patient']]);
    $hospitalization['link-patient'] = [
        'url' => "/controllers/patients/index.php?personalnumber=" . $hospitalization['patient'],
        'text' => $patient[0]['name']
    ];

    $hospitalization['link-room'] = [
        'url' => "/controllers/rooms/index.php?roomnumber=" . $hospitalization['room'],
        'text' => $hospitalization['room']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('hospitalizations.index', ['hospitalizations' => $hospitalizations])->render();
