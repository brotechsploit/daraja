<?php
use Dotenv\Dotenv;
use Brotechsploit\Daraja\Daraja;
$phonenumber = "254742513563";
$amount = (float)1;
$reference = 'VINCENT';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'consumerkey'    => $_ENV['MPESA_CONSUMER_KEY'],
    'consumersecret' => $_ENV['MPESA_CONSUMER_SECRET'],
    'shortcode'      => $_ENV['MPESA_SHORTCODE'],
    'passkey'        => $_ENV['MPESA_PASSKEY'],
    'callbackurl'    => $_ENV['MPESA_CALLBACK_URL'],
    'sandbox'        => true,
    'apiusername'    => $_ENV['MPESA_INITIATOR_USERNAME'],
    'apipassword'    => $_ENV['MPESA_SECURITY_CREDENTIALS'],
    'timeouturl'     => $_ENV['QueueTimeOutURL'],
    'resulturl'      => $_ENV['ResultURL']
];

$daraja = new Daraja($config);
$response = $daraja->stkPush($phonenumber,$amount,$reference);

if(isset($response['ResponseCode']) && $response['ResponseCode'] === "0"){
    $CheckoutRequestID = $response['CheckoutRequestID'];
    $MerchantRequestID = $response['MerchantRequestID'];
    echo "payment request successfull . an stk push has been send to your phonenumber";

    //// here you can run you other code i.e inserting  in the database
}
