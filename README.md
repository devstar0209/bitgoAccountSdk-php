# Bitgo-broker-php-sdk
It's a PHP SDK for Bitgo Broker API

[![Laravel 8|9](https://img.shields.io/badge/Laravel-8|9-orange.svg)](http://laravel.com)

[![Latest Stable Version](https://img.shields.io/packagist/v/devstar/Bitgo-broker-php-sdk.svg)](https://packagist.org/packagesdevstar/Bitgo-broker-php-sdk)

[![Total Downloads](https://poser.pugx.org/devstar/Bitgo-broker-php-sdk/downloads.png)](https://packagist.org/packages/devstar/Bitgo-broker-php-sdk)

[![License](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/devstar/Bitgo-broker-php-sdk)

## Requirements
- [PHP >= 8.0.2](http://php.net/)
- [Laravel Framework](https://github.com/laravel/framework)
## Install
composer require devstar/Bitgo-broker-php-sdk

## Usage
 ### Create Bitgo Broker client
$this->Bitgo = new Bitgo($key, $secret, $mode == 'pepper' ? true: false);

 ### Open an account
$this->Bitgo->account->create($params);

 ### Search all assets
$this->Bitgo->asset->getAssetsAll();

 ### Create an order
$this->Bitgo->trade->createOrder($account_id, $params);

 ### Transfer
$this->Bitgo->funding->createTransferEntity($account_id, $params);

 ### Document upload
$this->Bitgo->document->upload($account_id, $params);

