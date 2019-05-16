<?php
require_once("../includes/braintree_init.php");

$voidID = $_POST["void_ID"];
//Searching for transaction based on passed transaction ID
$transaction = $gateway->transaction()->find($voidID);

//Checking whether to issue a refund or a void
  if ($transaction->status == "authorized" || $transaction->status == "submitted_for_settlement"){
    $result = $gateway->transaction()->void($voidID);
    $transaction = $result->transaction;
    header("Location:" . $baseUrl . "void.php?id=" . $transaction->id);
  } else{
    $result = $gateway->transaction()->refund($voidID);
    $transaction = $result->transaction;
    header("Location:" . $baseUrl . "void.php?id=" . $transaction->id);
  }
