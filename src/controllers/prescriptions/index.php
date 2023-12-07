<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$doctor = $_GET['doctor'] ?? '';
$patient = $_GET['patient'] ?? '';
$medication = $_GET['medication'] ?? '';
$date = $_GET['date'] ?? '';
$description = $_GET['description'] ?? '';
$sort = $_GET['sort'] ?? '';
$direction = $_GET['direction'] ?? 'asc';

$query = "SELECT * FROM prescription WHERE doctor IN (SELECT doctorid FROM doctor WHERE name LIKE ?) AND patient LIKE ? AND medication IN (SELECT medicationid FROM medication WHERE name LIKE ?) AND date LIKE ? AND description LIKE ?";
$params = ['%' . $doctor . '%', '%' . $patient . '%', '%' . $medication . '%', '%' . $date . '%', '%' . $description . '%'];

if (!empty($sort)) {
    if ($sort == 'doctor') {
        $query .= " ORDER BY (SELECT name FROM doctor WHERE doctorid = prescription.doctor) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    } elseif ($sort == 'patient') {
        $query .= " ORDER BY patient " . ($direction === 'desc' ? 'DESC' : 'ASC');
    } elseif ($sort == 'medication') {
        $query .= " ORDER BY (SELECT name FROM medication WHERE medicationid = prescription.medication) " . ($direction === 'desc' ? 'DESC' : 'ASC');
    }
}

$prescriptions = executeQuery($query, $params);

foreach ($prescriptions as &$prescription) {
    
    $doctor = executeQuery("SELECT name FROM doctor WHERE doctorid = ?", [$prescription['doctor']]);
    $prescription['link-doctor'] = [
        'url' => "/controllers/doctors/index.php?doctorid=" . $prescription['doctor'],
        'text' => $doctor[0]['name']
    ];
    
    $patient = executeQuery("SELECT name FROM patient WHERE personalnumber = ?", [$prescription['patient']]);
    $prescription['link-patient'] = [
        'url' => "/controllers/patients/index.php?personalnumber=" . $prescription['patient'],
        'text' => $patient[0]['name']
    ];
    
    $medication = executeQuery("SELECT name FROM medication WHERE medicationid = ?", [$prescription['medication']]);
    $prescription['link-medication'] = [
        'url' => "/controllers/medications/index.php?medicationid=" . $prescription['medication'],
        'text' => $medication[0]['name']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('prescriptions.index', ['prescriptions' => $prescriptions])->render();
?>
