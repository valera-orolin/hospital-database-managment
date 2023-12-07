<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$blockid = $_GET['blockid'] ?? '';
$blockletter = $_GET['blockletter'] ?? '';
$floor = $_GET['floor'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM block WHERE blockletter LIKE ? AND floor LIKE ?";
$params = ['%' . $blockletter . '%', '%' . $floor . '%'];

if (!empty($blockid)) {
    $query .= " AND blockid = ?";
    $params[] = $blockid;
}

if (!empty($sort)) {
    $query .= " ORDER BY " . $sort . " " . ($direction === 'desc' ? 'DESC' : 'ASC');
}

$blocks = executeQuery($query, $params);

$blade = new Blade('../../views', '../../cache');
echo $blade->make('blocks.index', ['blocks' => $blocks])->render();
