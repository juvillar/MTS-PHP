<?php  require_once("../includes/braintree_init.php"); ?>
<html>
<?php require_once("../includes/head.php"); ?>
<body>

<?php
    if (isset($_GET["id"])) {
            $header = "Sweet Success";
            $icon = "success";
            $message = "Your Subscription has been successfully created.";
        }
?>
    <br><br>
    <img src="/images/<?php echo($icon)?>.svg" alt="">
    <br>
    <h1><?php echo($header)?></h1>
    <p><?php echo($message)?></p>
    <form method="post" id="passTxnForm" action="<?php echo $baseUrl;?>index.php">
    <button class="button" type="submit"><span>Home</span></button>
    </form>  
</body>
</html>
