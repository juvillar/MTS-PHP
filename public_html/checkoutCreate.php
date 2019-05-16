<?php
require_once("../includes/braintree_init.php");

$firstName = $_POST["createfirst_name"];
$lastName = $_POST["createlast_name"];
$phoneNumber = $_POST["createphone_number"];
$email = $_POST["createcustomer_email"];

//Create customer
$result = $gateway->customer()->create([
    'firstName' => $firstName,
    'lastName' => $lastName,
    'email' => $email,
    'phone' => $phoneNumber
]);

//Result Handling
if ($result->success) {
    header("Location: " . $baseUrl . "create.php?id=" . $result->customer->id);
} else {
    foreach($result->errors->deepAll() AS $error) {
        echo($error->code . ": " . $error->message . "\n");
    }
}
