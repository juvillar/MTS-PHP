# Braintree PHP Integration - MTS interview
An example PHP integration for Justine Villar's MTS interview - 05/15/2019. This integration was built to create transactions, refund those transactions, refund previous transactions, void previous transactions, and create subscriptions for new customers.

## Setup Instructions

1. Install composer within the example directory. You can find instructions on how to install composer [on composer's site](https://getcomposer.org/download/).

2. Run composer:

  ```sh
  php composer.phar install
  ```

3. Copy the contents of `example.env` into a new file named `.env` and fill in your Braintree API credentials. Credentials can be found by navigating to Account > My User > View Authorizations in the Braintree Control Panel. Full instructions can be [found on our support site](https://articles.braintreepayments.com/control-panel/important-gateway-credentials#api-credentials).

4. Start the internal PHP server on port 3000:

  ```sh
  php -S localhost:3000 -t public_html
  ```

## Running Tests

1. You can run this project's integration tests by adding your sandbox API credentials to `.env` and entering your  Sandbox specific credentials such as merchant ID, public key, and private key. You can find specific instructions on how to find these credentials in your Braintree Sandbox here on our important credentials page in our Support Articles [https://articles.braintreepayments.com/control-panel/important-gateway-credentials#merchant-id]

2.in checkoutRecurring.php there are three hardcoded plans that you will need to create in your Sandbox environment before you are able to create subscriptions via the API. The three plans and corresponding IDs are as follows: planone/tjd2, plantwo/2wbw, and planthree/gtq6. You can find instructions on how to create plans and subscriptions in Braintree's support articles [https://articles.braintreepayments.com/guides/recurring-billing/overview]

## Testing Transactions

1. Sandbox transactions must be made with sample credit card values [https://developers.braintreepayments.com/reference/general/testing/php#credit-card-numbers]
