<?php
require '../../models/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$paymentid = $_GET['paymentid'] ?? '';
$bill = $_GET['bill'] ?? '';
$date_paid = $_GET['date_paid'] ?? '';
$amount = $_GET['amount'] ?? '';

$query = "SELECT * FROM payment WHERE bill  LIKE ? AND amount LIKE ?";
$params = ['%' . $bill . '%', '%' . $amount . '%'];

if (!empty($paymentid)) {
    $query .= " AND paymentid = ?";
    $params[] = $paymentid;
}

if (!empty($date_paid)) {
    $query .= " AND date_paid = ?";
    $params[] = $date_paid;
}

$payments = executeQuery($query, $params);

foreach ($payments as &$payment) {
    
    $bill = executeQuery("SELECT date_issued FROM bill WHERE billid = ?", [$payment['bill']]);
    $payment['link-bill'] = [
        'url' => "/controllers/bills/index.php?billid=" . $payment['bill'],
        'text' => $bill[0]['date_issued']
    ];
}

$blade = new Blade('../../views', '../../cache');
echo $blade->make('payments.index', ['payments' => $payments])->render();
