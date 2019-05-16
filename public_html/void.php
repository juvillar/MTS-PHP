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
      Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT
    ];

    $transactionUnsuccessfulStatuses = [
      Braintree\Transaction::SETTLED,
      Braintree\Transaction::SETTLING
    ];

    if (!in_array($transaction->status, $transactionSuccessStatuses)) {
        $header = "Sweet Success";
        $icon = "success";
        $message = "Your Void was successful and is in the works!";
    } else{
        $header = "This void has failed!";
        $icon = "fail";
        $message = "You can only issue a void when the status of a transaction is Authorized or
                    Submitted for Settlement.Your transaction has a status of Settling or Settled,
                    a Refund was issued instead.";
    }
  }
?>
    <br><br>
    <img src="/images/<?php echo($icon)?>.svg" alt=""><br>
    <h1><?php echo($header)?></h1>
    <p><?php echo($message)?></p>

    <form method="post" id="voidHome" action="<?php echo $baseUrl;?>index.php">
    <button class="button" type="submit"><span>Home</span></button>
    </form>
</body>
</html>
