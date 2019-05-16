<?php
require_once("../includes/braintree_init.php");

$refundID = $_POST["txn_ID"];

//Searching for transaction based on passed transaction ID
$transaction = $gateway->transaction()->find($refundID);

//Checking whether to issue a refund or a void
  if ($transaction->status == "authorized" || $transaction->status == "submitted_for_settlement"){
        $result = $gateway->transaction()->void($refundID);
        $transaction = $result->transaction;
        header("Location: " . $baseUrl . "immediate.php?id=" . $transaction->id);
  } else if ($transaction->status == "settling" || $transaction->status == "settled"){
        $result = $gateway->transaction()->refund($refundID);
        $transaction = $result->transaction;
        header("Location: " . $baseUrl . "immediate.php?id=" . $transaction->id);
  } else {
        $errorString = "";
        foreach($result->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }
  }
