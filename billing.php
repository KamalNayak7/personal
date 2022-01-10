<?php

require_once("billingPlan.php");
require_once("bootstrap.php");


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

// Get payment object by passing paymentId
$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $apiContext);
$payerId = $_GET['PayerID'];

// Execute payment with payer ID
$execution = new PaymentExecution();
$execution->setPayerId($payerId);


try {
  // Execute payment
  $result = $payment->execute($execution, $apiContext);
  var_dump($result);
} catch (PayPal\Exception\PayPalConnectionException $ex) {
  echo $ex->getCode();
  echo $ex->getData();
  die($ex);
} catch (Exception $ex) {
  die($ex);
}
?>