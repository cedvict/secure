# Encrypt and Decrypt for Slim Framework 3
Based on RSA algorithm for Slim framework. Secure works well as class library (inject) for Slim framework 3 application.

## Install
You can install Logger via [composer](https://getcomposer.org/).

``
$ composer require cedvict/secure
``

Requires Slim Framework 3 and PHP 5.5.0 or newer. Visit Secure repository at [Packagist](https://packagist.org/packages/cedvict/secure).

## Usage

### Class Library

To use Secure as class library, you can simply inject Secure instance into Slim container.

```php
<?php

require "vendor/autoload.php";

$container = new \Slim\Container();

// Adding logger to Slim container
$container['secure'] = function($c) {
  return new Cedvict\Secure('public_key_file', 'private_key_file', 'passphrase');
};

$app = new \Slim\App($container);

$app->get('/', function ($request, $response, $args) {

  // encrypt data before send
  $encData = $this->secure->encrypt("This message from secure class library");
  // decrypt data get
  $realData = $this->secure->decrypt($request->getParam('data'));

  return $response->write($encData . ' - ' . $realData);
});


$app->run();

```
