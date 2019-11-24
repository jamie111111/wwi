<?php
session_start();
require_once('lib/mollie/vendor/autoload.php');

$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey("test_gTT7NU33MBzu5pCgV9qfa472FjuBaA");

if (isSet($_SESSION['paymentId'])) {
    $payment = $mollie->payments->get($_SESSION['paymentId']);
    $body = '
    <div class="content-container">
        <h1>Terugkoppeling van mollie</h1>
        <p>Status: ' . $payment->status . '</p>
    </div>
';
    unset($_SESSION['paymentId']);
} else {
    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => "10.00"
        ],
        "method" => "ideal",
        "description" => "My first API payment",
        "redirectUrl" => "http://localhost/mollie"
    ]);

    $_SESSION['paymentId'] = $payment->id;

    header("Location: " . $payment->getCheckoutUrl(), true, 303);
}

$view = array(
    'title' => 'Wide World Importers - Mollie test',
    'head' => '',
    'body' => $body,
    'showHeader' => true,
    'showFooter' => true,
);
