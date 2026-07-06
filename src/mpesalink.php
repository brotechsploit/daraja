<?php
require __DIR__ . '/../configs/config.php';
return [
    'consumerkey' => MPESA_CONSUMER_KEY,
    'consumersecret' => MPESA_CONSUMER_SECRET,
    'shortcode' => MPESA_SHORTCODE,
    'passkey' => MPESA_PASSKEY,
    'callbackurl' => MPESA_CALLBACK_URL,
    'sandbox' => false,
    'apiusername' => MPESA_API_USERNAME,
    'apipassword' => MPESA_API_PASSWORD,
    'timeouturl' => QueueTimeOutURL,
    'resulturl' => ResultURL

];
