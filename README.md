# CoinPayments PHP library FIXED

** FIXED **

I fork original repository and fix it, now it works well with CoinPayments Api

This is basic PHP library for [CoinPayments API](https://goo.gl/mj98qm).


## Sample usage


```php
use Delarge\CoinPayments;

$coinPaymentsAPI = new CoinPayments($merchantID, $publicKey, $privateKey, $ipnSecret);

// Get conversion rates for all supported currencies
$rates = $coinPaymentsAPI->getRates()->getResponse();

// Sample transaction for 16$
$coinPaymentsAPI->createTransaction(16, 'USD', 'BTC', $additional = [])->getResponse();
```

## Getting Started

### Requirements

* PHP >= 7.1

This library does not have any external dependencies. 


### Installation

The recommended way to install this library is through Composer.


```sh
# Install Composer
curl -sS https://getcomposer.org/installer | php
```
Next, run the Composer command to install the latest stable version of CoinPayments PHP library:

```sh
composer require andre_delarge/coinpayments
```
After installing, you need to require Composer's autoloader:
```php
require 'vendor/autoload.php';
```
You can then later update library using composer:
```sh
composer.phar update
```

## Contributing

Please read CONTRIBUTING.md for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

* **Žiga Drnovšček** - *Initial work* - [Sigismund](https://github.com/sigismund)
* **Andrew Delarge** - *Fixing* - [AndrewDelarge](https://github.com/andrewdelarge)

See also the list of [contributors](https://github.com/andrewdelarge/coinpayments/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
