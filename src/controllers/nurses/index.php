<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$nurses = executeQuery("SELECT * FROM nurse");

$blade = new Blade('../../views', '../../cache');
echo $blade->make('nurses.index', ['nurses' => $nurses])->render();