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
├── configs/
│   └── (Configuration files)
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

Create your configuration file or update the existing one.

Example:

```php
return [
    'consumerKey' => 'YOUR_CONSUMER_KEY',
    'consumerSecret' => 'YOUR_CONSUMER_SECRET',
    'shortCode' => '174379',
    'passKey' => 'YOUR_PASSKEY',
    'callbackUrl' => 'https://yourdomain.com/callback.php',
    'environment' => 'sandbox'
];
```

---

## Basic Usage

```php
<?php

require 'vendor/autoload.php';

use YourVendor\Daraja\Daraja;

$config = require 'configs/classconnect.php';

$daraja = new Daraja($config);

$response = $daraja->stkPush(
    '254712345678',
    1,
    'Payment'
);

print_r($response);
```

---


## Callback Handling

Configure your callback URL inside your Safaricom Developer Portal.
we have a sample of the callback code in the mpesaresults callback.php
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
