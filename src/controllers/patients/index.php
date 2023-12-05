<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$patients = executeQuery("SELECT * FROM patient");

$blade = new Blade('../../views', '../../cache');
echo $blade->make('patients.index', ['patients' => $patients])->render();