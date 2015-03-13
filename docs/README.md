# Introduction
Library includes all the functionality provided by API. Library was designed to be flexible and self-explanatory for developers to implement.
Client provides use of API in OOP style.

## Authentication
You don't have to bother about it. Authentication is handled auto-magically behind the scenes.

## Initialize the client object
```php
use Cardinity\Client;
$client = Client::create([
    'consumerKey' => 'YOUR_CONSUMER_KEY',
    'consumerSecret' => 'YOUR_CONSUMER_SECRET',
]);
```

## Payments [API](https://developers.cardinity.com/api/v1/#payments)
### Create new payment
```php
use Cardinity\Method\Payment;
$method = new Payment\Create([
    'amount' => 50.00,
    'currency' => 'EUR',
    'settle' => false,
    'description' => 'some description',
    'order_id' => '12345678',
    'country' => 'LT',
    'payment_method' => Payment\Create::CARD,
    'payment_instrument' => [
        'pan' => '4111111111111111',
        'exp_year' => 2016,
        'exp_month' => 12,
        'cvc' => 456,
        'holder' => 'Mike Dough'
    ],
]);

/** @type Cardinity\Method\Payment\Payment */
$payment = $client->call($method);

$paymentId = $payment->getId();
```

### Create recurring payment

### Finalize pending payment

### Get existing payment

### Get all payments

### Declined!!!


## Errors
### Declined!!!
