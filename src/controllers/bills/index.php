<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$billid = $_GET['billid'] ?? '';
$patient = $_GET['patient'] ?? '';
$date_issued = $_GET['date_issued'] ?? '';
$total_cost = $_GET['total_cost'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM bill WHERE patient IN (SELECT personalnumber FROM patient WHERE name LIKE ?) AND total_cost LIKE ?";
$params = ['%' . $patient . '%', '%' . $total_cost . '%'];

if (!empty($billid)) {
    $query .= " AND billid = ?";
    $params[] = $billid;
}

if (!empty($date_issued)) {
    $query .= " AND date_issued = ?";
    $params[] = $date_issued;
}

if (!empty($sort)) {
    if ($sort == 'patient') {
        $query .= " ORDER BY (SELECT name FROM patient WHERE personalnumber = bill.patient) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
}

$bills = executeQuery($query, $params);

foreach ($bills as &$bill) {
    
    $patient = executeQuery("SELECT name FROM patient WHERE personalnumber = ?", [$bill['patient']]);
    $bill['link-patient'] = [
        'url' => "/controllers/patients/index.php?personalnumber=" . $bill['patient'],
        'text' => $patient[0]['name']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('bills.index', ['bills' => $bills])->render();
