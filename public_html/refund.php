<?php  require_once("../includes/braintree_init.php"); ?>
<html>
<?php require_once("../includes/head.php"); ?>
<body>

<?php
if (isset($_GET["id"])) {
    $transaction = $gateway->transaction()->find($_GET["id"]);

    $transactionSuccessStatuses = [
        Braintree\Transaction::SETTLED,
        Braintree\Transaction::SETTLING,
    ];

    $transactionUnsuccessfulStatuses = [
        Braintree\Transaction::AUTHORIZED,
        Braintree\Transaction::AUTHORIZING,
        Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT
    ];

    if (!in_array($transaction->status, $transactionSuccessStatuses)) {
        $header = "Sweet Success";
        $icon = "success";
        $message = "Your refund is in the works!";
    } else{
        $header = "This refund was unsuccessful";
        $icon = "fail";
        $message = "You can only issue a refund when the status of a transaction is Settling or Settled";
    }
  }
?>
    <br><br>
    <img src="/images/<?php echo($icon)?>.svg" alt="">
    <br>
    <h1><?php echo($header)?></h1>
    <p><?php echo($message)?></p>
    <form method="post" id="refundHome" action="<?php echo $baseUrl;?>index.php">
    <button class="button" type="submit"><span>Home</span></button>
    </form>
</body>
</html>
