<?php
require_once("../includes/braintree_init.php");

$amount = $_POST["amount"];
$nonce = $_POST["payment_method_nonce"];
$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["txncustomer_email"];
$phone = $_POST["txnphone_number"];

//Create Transaction
$result = $gateway->transaction()->sale([
    'amount' => $amount,
    'paymentMethodNonce' => $nonce,
    'customer' => [
      'firstName' => $firstName,
      'lastName' => $lastName,
      'phone' => $phone,
      'email' => $email,
    ],
    'options' => [
        'submitForSettlement' => true
    ]
]);

//result handling
if ($result->success || !is_null($result->transaction)) {
    $transaction = $result->transaction;
    header("Location: " . $baseUrl . "transaction.php?id=" . $transaction->id);
}
