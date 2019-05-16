<?php require_once("../includes/braintree_init.php"); ?>

<html>
<?php require_once("../includes/head.php"); ?>
    <style> <?php include 'css/styles.css'; ?> </style>
<body>

    <br><br>
    <h1>Braintree - Justine Villar</h1>
    <div class="container">

      <!-- Button 1 - Tranactions -->
      <button class="accordion">Transaction</button>
      <div class="accordion-content">
        <form method="post" id="payment-form" action="<?php echo $baseUrl;?>checkout.php">
            <section>
              <br>
              <label for="first-name">First Name: &nbsp;&nbsp;</label>
              <input name="first_name" id="first_name" type="text">&nbsp;&nbsp;

              <label for="last-name">Last Name:</label>
              <input name="last_name" id="last_name" type="text"><br><br>

              <label for="txnphone-number">Phone Number:</label>&nbsp;
              <input name="txnphone_number" id="txnphone_number" type="text"> &nbsp;&nbsp;

              <label for="txncustomer-email">Email: &nbsp;&nbsp;</label>
              <input name="txncustomer_email" id="txncustomer_email" type="text"><br> <br><br>

                <label for="amount">
                    <span class="input-label">Amount</span>
                    <div class="input-wrapper amount-wrapper">
                        <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
                    </div>
                </label>
                <br>
                <div class="bt-drop-in-wrapper">
                    <div id="bt-dropin"></div>
                </div>
            </section>

            <input id="nonce" name="payment_method_nonce" type="hidden" />
            <button class="button" type="submit"><span>Submit</span></button>
        </form>
      </div>

      <!-- Button 2 - Refunds -->
      <button class="accordion">Refund</button>
      <div class="accordion-content">
        <p>
          <form method="post" id="refund-form" action="<?php echo $baseUrl;?>checkoutRefund.php">
            <label for="txn-ID">Transaction ID:</label>
            <input name="txn_ID" id="txn_ID" type="text"><br><br>
            <button class="button" type="submit"><span>Submit</span></button>
          </form>
        </p>
      </div>

      <!-- Button 3 - Voids -->
      <button class="accordion">Void</button>
      <div class="accordion-content">
        <p>
          <form method="post" id="refund-form" action="<?php echo $baseUrl;?>checkoutVoid.php">
            <label for="txn-ID">Transaction ID:</label>
            <input name="void_ID" id="void_ID" type="text"><br><br>
            <button class="button" type="submit"><span>Submit</span></button>
          </form>
        </p>
      </div>

      <!-- Button 4 - Customer Create -->
      <button class="accordion">Create Customer</button>
      <div class="accordion-content">
        <p>
          <form method="post" id="customercreate-form" action="<?php echo $baseUrl;?>checkoutCreate.php">
            <label for="createfirst-name">First Name: &nbsp;&nbsp;</label>
            <input name="createfirst_name" id="createfirst_name" type="text"> &nbsp;&nbsp;

            <label for="createlast-name">Last Name: </label>
            <input name="createlast_name" id="createlast_name" type="text"><br><br>

            <label for="createphone-number">Phone Number:</label>&nbsp;
            <input name="createphone_number" id="createphone_number" type="text"> &nbsp;&nbsp;

            <label for="ceatecustomer-email"> Email: &nbsp;&nbsp;&nbsp;</label>
            <input name="createcustomer_email" id="createcustomer_email" type="text"><br><br><br>
            <button class="button" type="submit"><span>Submit</span></button>
          </form>
        </p>
      </div>

      <!-- Button 5 - Subscriptions -->
      <button class="accordion">Subscriptions</button>
      <div class="accordion-content">
        <form method="post" id="subpayment-form" action="<?php echo $baseUrl;?>checkoutRecurring.php">
          <section>
              <br>
              <label for="subfirst-name">First Name: &nbsp;&nbsp;</label>
              <input name="subfirst_name" id="subfirst_name" type="text"> &nbsp;&nbsp;

              <label for="sublast-name">Last Name: </label>
              <input name="sublast_name" id="sublast_name" type="text"><br><br>

              <label for="subphone-number">Phone Number:</label>&nbsp;
              <input name="subphone_number" id="subphone_number" type="text"> &nbsp;&nbsp;

              <label for="subcustomer-email"> Email: &nbsp;&nbsp;&nbsp;</label>
              <input name="subcustomer_email" id="subcustomer_email" type="text"><br> <br>

              <input type="radio" name="subscription" value="planone" id="planone" checked=true > Plan 1 - $10<br>
              <input type="radio" name="subscription" value="plantwo" id="plantwo"> Plan 2 - $20<br>
              <input type="radio" name="subscription" value="planthree" id="planthree"> Plan 3 - $30<br><br>

              <div class="bt-drop-in-wrapper">
              <div id="bt-subdropin"></div>
            </section>

            <input id="subradio" name="subscription_radio_button" type="hidden" />
            <input id="subnonce" name="subpayment_method_nonce" type="hidden" />
            <input id="subtoken" name="subclient_token" type="hidden" />

            <button class="button" type="submit"><span>Submit</span></button>
        </form>
      </div>
    </div>

    <!-- scripts -->
    <script src="https://js.braintreegateway.com/web/dropin/1.17.2/js/dropin.min.js"></script>


    <script>
        //Transaction Drop-In
        var form = document.querySelector('#payment-form');
        var client_token = "<?php echo($gateway->ClientToken()->generate()); ?>";

        braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          paypal: {
            flow: 'vault'
          }
        }, function (createErr, instance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Request Payment Method Error', err);
                return;
              }

              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          });
        });
        </script>

<!--
        <script>
        //Setting cookie expiration time
        var now = new Date();
        var time = now.getTime();
        var expireTime = time + 10000;
        now.setTime(expireTime);

        //Grabbing selected radio button value & setting cookie
        var radios = document.getElementsByName('subscription');
        for (var i = 0, length = radios.length; i < length; i++)
        {
         if (radios[i].checked)
         {
          //Only one radio button can be checked, so set cookie & exit
          document.cookie='planselect='+ radios[i].value + '; expires=' + now.toUTCString() + ';  public_html/checkoutRecurring.php'
          //document.querySelector('#subradio').value = radios[i].value;
          break;
        }}

        //Drop-In for Recurring Billing
        var form = document.querySelector('#subpayment-form');
        var subclient_token = "<?php echo($gateway->ClientToken()->generate()); ?>";

        braintree.dropin.create({
          authorization: subclient_token,
          selector: '#bt-subdropin',
          paypal: {
            flow: 'vault'
          }
        },function (createErr, instance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Request Payment Method Error', err);
                return;
              }

              //Add the nonce to the form and submit
              document.querySelector('#subnonce').value = payload.nonce;

              //Add the token to the form and submit
              document.querySelector('#subtoken').value = subclient_token;
              form.submit();
            });
          });
        });
    </script>
-->

    <script src="javascript/demo.js"></script>

    <!-- Script for the opening and closing the drawers -->
    <script src="javascript/scripts.js"></script>

</body>
</html>
