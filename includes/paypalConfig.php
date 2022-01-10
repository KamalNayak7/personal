<?php
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AVAX6Hf2y5C99_Fm52ft-2HUfYImtsA7ZjxYa_8QMTb53ADN27faQH7nOdBw857zsPqAFMpsH9ofzzUc',     // ClientID
        'EFrEg8mnrG-ObeWtoycz05f6jzpveENLI9QEngQybgdGYLE4gV4G_ZXLX2EBS7gq1nfY6YipQizDlCwg'      // ClientSecret
    )
);

?>