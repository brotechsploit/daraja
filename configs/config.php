<?php
require __DIR__.'/../vendor/autoload.php';
date_default_timezone_set('Africa/Nairobi');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
define('MPESA_CONSUMER_KEY', $_ENV['MPESA_CONSUMER_KEY']);
define('MPESA_CONSUMER_SECRET', $_ENV['MPESA_CONSUMER_SECRET']);
define('MPESA_SHORTCODE',$_ENV['MPESA_SHORTCODE']);
define('MPESA_PASSKEY', $_ENV['MPESA_PASSKEY']);
define('MPESA_CALLBACK_URL', $_ENV['MPESA_CALLBACK_URL']);
define('MPESA_API_USERNAME',$_ENV['MPESA_INITIATOR_USERNAME']);
define('MPESA_API_PASSWORD',$_ENV['MPESA_SECURITY_CREDENTIALS']);
define('QueueTimeOutURL',$_ENV['ResultURL']);
define('ResultURL',$_ENV['ResultURL']);
