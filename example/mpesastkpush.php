<?php
use Brotechsploit\Daraja\Daraja;
$phonenumber = "254742513563";
$amount = (float)1;
$reference = 'VINCENT';
$configs = require __DIR__.'/../configs/classconnect.php';

$daraja = new Daraja($configs);
$response = $daraja->stkPush($phonenumber,$amount,$reference);

if(isset($response['ResponseCode']) && $response['ResponseCode'] === "0"){
    $CheckoutRequestID = $response['CheckoutRequestID'];
    $MerchantRequestID = $response['MerchantRequestID'];
    echo "payment request successfull . an stk push has been send to your phonenumber";

    //// here you can run you other code i.e inserting  in the database
}
