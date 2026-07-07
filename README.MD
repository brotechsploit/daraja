## brotechsploit daraja APi intergration
## mpesa stk push made easy , b2c , b2b 

# Daraja API PHP SDK

A lightweight Object-Oriented PHP SDK for integrating with the Safaricom Daraja API for effecient mpesa payments

This package simplifies working with Daraja services such as STK Push, STK Push Query, OAuth token generation, and other supported endpoints.

---

## Features

* Object-Oriented API
* Composer compatible
* OAuth Access Token generation
* STK Push
* B2c payments
* B2B Payments
* B2Pochi payments
* Configurable using PHP configuration files
* Simple and easy to integrate

---

## Requirements

* PHP 8.1 or later
* Composer
* Safaricom Daraja API credentials

---

## Installation

Install the package using Composer:

```bash
composer require brotechsploit/daraja-api
```



---

## Project Structure

```
daraja/
│
│
│
├── callback/
│   └── (Callback responses)
│
├── .env
│
├── example/
│
│── composer.json
│── composer.lock
│── src/
│   └── Daraja.php
│── vendor/
│   ├── autoload.php
│   ├── composer/
│   │   ├── autoload_psr4.php
│   │   ├── autoload_real.php
│   │   └── ...
│   └── vlucas/
```

---

## Configuration

edit the .env file with the valid safaricom daraja credentials 

Example:
MPESA_CONSUMER_KEY=qP50LHCHnaIJajKsOMZAxbC3v0PoGvaj4GhQa02pszLy0e00
MPESA_CONSUMER_SECRET=i7dP8GRQJ4G6avPzM4GfUBKvAJ4pdaRUT0SajUPuEfnUhjAhSScGR4YHcIwnwPKW
MPESA_PASSKEY=bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919
MPESA_SHORTCODE=174379
MPESA_CALLBACK_URL=https://example.com/callback/
MPESA_INITIATOR_USERNAME=apiuser
MPESA_SECURITY_CREDENTIALS=i7dP8GRQJ4G6avPzM4GfUBKvAJ4pdaRUT0SajUPuEfnUhjAhSScGR4YHcIwnwPKW
QueueTimeOutURL=https://example.com/timeout.php
ResultURL=https://example.com/result.php

```php , match with the  config as sampled below in mpesa stk file 
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
```

---

## Basic Usage

```php
<?php
use Dotenv\Dotenv;
use Brotechsploit\Daraja\Daraja;
$phonenumber = "254742513563";
$amount = (float)1;
$reference = 'VINCENT';
$dotenv = Dotenv::createImmutable(__DIR__);// change to fit .env directory
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

print_r($response);
```

---


## Callback Handling

Configure your callback URL inside your Safaricom Developer Portal.
we have a sample of the callback code in the  callback/callback.php
The callback data can then be processed and stored according to your application's requirements.
---

## Environment

The package supports:

* Sandbox
* Production

Simply update your configuration to switch environments.

---

## Example

An example implementation is provided in:

```
/example/mpesastkpush.php
```

---

## Security

Do not commit your production credentials.

Store sensitive information in your `.env` file and exclude it from version control using `.gitignore`.

---

## Contributing

Contributions, bug reports, and feature requests are welcome.

1. Fork the repository.
2. Create a feature branch.
3. Commit your changes.
4. Open a Pull Request.

---



## Author

Vincent Oloo

If you find this package useful, consider giving the repository a ⭐ on GitHub.
