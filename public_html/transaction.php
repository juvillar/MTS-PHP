<?php  require_once("../includes/braintree_init.php"); ?>
<html>
<?php require_once("../includes/head.php"); ?>
<body>

<?php

    if (isset($_GET["id"])) {
        $transaction = $gateway->transaction()->find($_GET["id"]);

        $transactionSuccessStatuses = [
            Braintree\Transaction::AUTHORIZED,
            Braintree\Transaction::AUTHORIZING,
            Braintree\Transaction::SETTLED,
            Braintree\Transaction::SETTLING,
            Braintree\Transaction::SETTLEMENT_CONFIRMED,
            Braintree\Transaction::SETTLEMENT_PENDING,
            Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT
        ];

        if (in_array($transaction->status, $transactionSuccessStatuses)) {
            $header = "Sweet Success";
            $icon = "success";
            $message = "Your test transaction has been successfully processed.";
        } else {
            $header = "Transaction Failed";
            $icon = "fail";
            $message = "Your transaction has a status of " . $transaction->status . ".";
        }
    }
?>
    <br><br>
    <img src="/images/<?php echo($icon)?>.svg" alt="">
    <br>
    <h1><?php echo($header)?></h1>
    <p><?php echo($message)?></p>

    <form method="post" id="passTxnForm" action="<?php echo $baseUrl;?>immediateRefund.php">
    <input id="txnID" name="passedTransaction" type="hidden" value="<?php echo $transaction->id ?>"/>
    <button class="button" type="submit"><span>Refund</span></button>
    </form>

    <form method="post" id="txnHome" action="<?php echo $baseUrl;?>index.php">
    <button class="button" type="submit"><span>Home</span></button>
    </form>
</body>
</html>
