<?php
require_once("includes/paypalConfig.php");
require_once("includes/config.php");
require_once("includes/classes/Entity.php");





use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


$entityId = $_GET["id"];
$payment = new Entity($con ,$entityId);
$entityName = $payment->getName();
$amountINR = $payment->getAmountInr();
$thumbnail = $payment->getThumbnail();


// Create new payer and method
$payer = new Payer();
$payer->setPaymentMethod("paypal");

$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$returnUrl = str_replace("billing.php", "success.php", $currentUrl);

// Set redirect URLs
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($returnUrl."?id=$entityId"."?success=true")
  ->setCancelUrl($returnUrl."?success=false");

// Set payment amount
$amount = new Amount();
$amount->setCurrency("USD")
  ->setTotal($amountINR);

// Set transaction object
$transaction = new Transaction();
$transaction->setAmount($amount)
  ->setDescription("Payment for $entityName");

// Create the full payment object
$payment = new Payment();
$payment->setIntent('sale')
  ->setPayer($payer)
  ->setRedirectUrls($redirectUrls)
  ->setTransactions(array($transaction));




try {
  $payment->create($apiContext);
 
  // Get PayPal redirect URL and redirect the customer
  $approvalUrl = $payment->getApprovalLink();
  header("Location: $approvalUrl");
  // Redirect the customer to $approvalUrl
} catch (PayPal\Exception\PayPalConnectionException $ex) {
  echo $ex->getCode();
  echo $ex->getData();
  die($ex);
} catch (Exception $ex) {
  die($ex);
}


?>