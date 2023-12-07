<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$roomnumber = $_GET['roomnumber'] ?? '';
$roomtype = $_GET['roomtype'] ?? '';
$block = $_GET['block'] ?? '';
$isavailable = $_GET['isavailable'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM room WHERE roomtype LIKE ? AND isavailable LIKE ? AND block LIKE ?";
$params = ['%' . $roomtype . '%', '%' . $isavailable . '%', '%' . $block . '%'];

if (!empty($roomnumber)) {
    $query .= " AND roomnumber = ?";
    $params[] = $roomnumber;
}

$rooms = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('rooms.index', ['rooms' => $rooms])->render();
