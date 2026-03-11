<?php

require 'vendor/autoload.php';

use App\Entity\Payment;
use App\Handlers\FailedPaymentHandler;
use App\Handlers\PendingPaymentHandler;
use App\Handlers\RedirectPaymentHandler;
use App\Handlers\SuccessPaymentHandler;
use App\PaymentProcessor;
use App\Registry\PaymentHandlerRegistry;

$registry = new PaymentHandlerRegistry();

$registry->registerHandler(new SuccessPaymentHandler());
$registry->registerHandler(new PendingPaymentHandler());
$registry->registerHandler(new FailedPaymentHandler());
$registry->registerHandler(new RedirectPaymentHandler());

$processor = new PaymentProcessor($registry);

$paymentFromDb = new Payment(1, 'prepared');

$rawData = [
    'orderId' => 'ORDER_X1', 
    'orderAmount' => '1.99',
    'orderCurrency' => 'USD',
    'orderDescription' => 'Product',
    'cardNumber' => '4111111111111111',
    'cardExpMonth' => '12', // 12 - redirect, 01 - success, 02 - failure, 03 should be pending - but returns 'declined' - failure...
    'cardExpYear' => '2038',
    'cardCVV' => '000',
    'payerFirstName' => 'John',
    'payerLastName' => 'Doe',
    'payerAddress' => 'BigStreet',
    'payerCountry' => 'US',
    'payerCity' => 'City',
    'payerZip' => '123456',
    'payerEmail' => 'doe@example.com',
    'payerPhone' => '199999999',
    'payerIP' => '123.123.123.123',
    'termUrl3ds' => 'http://client.site.com/return.php',
];

$result = $processor->process($paymentFromDb, $rawData);

echo $result->status . PHP_EOL;
echo $result->message . PHP_EOL;

if ($result->status === 'redirect') {
    echo '<form action="' . $result->redirectUrl . '" method="POST">';
    echo '<button type="submit">Continue payment</button>';
    echo '</form>';
}