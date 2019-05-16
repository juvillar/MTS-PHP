<?php
require_once("../includes/braintree_init.php");

$firstName = $_POST["subfirst_name"];
$lastName = $_POST["sublast_name"];
$phoneNumber = $_POST["subphone_number"];
$email = $_POST["subcustomer_email"];
$planSelected = $_POST["subscription_radio_button"];
$nonce = $_POST["subpayment_method_nonce"];
$planID = '';

//Set Plan ID
if ($planSelected == "planone") {
  $planID = "tjd2";
}
elseif ($planSelected == "plantwo") {
  $planID = "2wbw";
}
else {
  $planID = "gtq6";
}

//Create Customer
$customerCreate = $gateway->customer()->create(array(
    'firstName' => $firstName,
    'lastName' => $lastName,
    'email' => $email,
    'phone' => $phoneNumber,
    'paymentMethodNonce' => $nonce
));

$token = $customerCreate->customer->paymentMethods[0]->token;

//Create Subscription
$result = $gateway->subscription()->create([
  'paymentMethodToken' => $token,
  'planId' => $planID
]);

//Result Handling
if ($result->success) {
    header("Location: " . $baseUrl . "recurring.php?id=" . $result->subscription->id);
} else {
    foreach($result->errors->deepAll() AS $error) {
        echo($error->code . ": " . $error->message . "\n");
    }
}
