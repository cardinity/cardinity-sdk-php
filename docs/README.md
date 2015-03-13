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
```

### Handling declined payments
In case payment could not be processed `Cardinity\Exception\Declined` 
exception will be thrown.

```php
use Cardinity\Exception;
use Cardinity\Method\Payment;

$method = new Payment\Create([
    'amount' => 150.01,
    'currency' => 'EUR',
    'settle' => false,
    'description' => 'some description',
    'order_id' => '12345678',
    'country' => 'LT',
    'payment_method' => Payment\Create::RECURRING,
    'payment_instrument' => [
        'pan' => '4111111111111111',
        'exp_year' => 2016,
        'exp_month' => 12,
        'cvc' => 456,
        'holder' => 'Mike Dough'
    ],
]);

try {
    /** @type Cardinity\Method\Payment\Payment */
    $payment = $client->call($method);
} catch (Exception\Declined $exception) {
    /** @type Cardinity\Method\Payment\Payment */
    $payment = $exception->getResult();
    $status = $payment->getStatus(); // value will be 'declined'
    $errors = $exception->getErrors(); // list of errors occured
}
```

### Create recurring payment
```php
use Cardinity\Method\Payment;
$method = new Payment\Create([
    'amount' => 50.00,
    'currency' => 'EUR',
    'settle' => false,
    'description' => 'some description',
    'order_id' => '12345678',
    'country' => 'LT',
    'payment_method' => Payment\Create::RECURRING,
    'payment_instrument' => [
        'payment_id' => $paymentId
    ],
]);
/** @type Cardinity\Method\Payment\Payment */
$payment = $client->call($method);
```

### Finalize pending payment
```php
use Cardinity\Method\Payment;
$method = new Payment\Finalize($payment->getId(), $payment->getAuthorizationInformation()->getData());
/** @type Cardinity\Method\Payment\Payment */
$payment = $client->call($method);
```

### Get existing payment
```php
use Cardinity\Method\Payment;
$method = new Payment\Get($payment->getId());
/** @type Cardinity\Method\Payment\Payment */
$payment = $client->call($method);
```

### Get all payments
```php
use Cardinity\Method\Payment;
$method = new Payment\GetAll();
$result = $client->call($method);
/** @type Cardinity\Method\Payment\Payment */
$payment = $result[0];
```

## Refunds [API](https://developers.cardinity.com/api/v1/#refunds)
### Create new refund
```php
use Cardinity\Method\Refund;
$method = new Refund\Create(
    $payment->getId(),
    10.00,
    'my description'
);
/** @type Cardinity\Method\Refund\Refund */
$refund = $client->call($method);
```

### Handling declined refunds
In case refund could not be processed `Cardinity\Exception\Declined` 
exception will be thrown.

```php
use Cardinity\Exception;
use Cardinity\Method\Refund;

$method = new Refund\Create(
    $payment->getId(),
    10.00,
    'fail'
);

try {
    /** @type Cardinity\Method\Refund\Refund */
    $refund = $client->call($method);
} catch (Exception\Declined $exception) {
    /** @type Cardinity\Method\Refund\Refund */
    $refund = $exception->getResult();
    $status = $refund->getStatus(); // value will be 'declined'
    $errors = $exception->getErrors(); // list of errors occured
}
```

### Get existing refund
```php
use Cardinity\Method\Refund;
$method = new Refund\Get(
    $payment->getId(),
    $refund->getId()
);
/** @type Cardinity\Method\Refund\Refund */
$refund = $client->call($method);
```

### Get all refunds
```php
use Cardinity\Method\Refund;
$method = new Refund\GetAll(
    $payment->getId()
);
$result = $client->call($method);
/** @type Cardinity\Method\Refund\Refund */
$refund = $result[0];
```

## Settlements [API](https://developers.cardinity.com/api/v1/#settlements)
### Create new settlement
```php
use Cardinity\Method\Settlement;
$method = new Settlement\Create(
    $payment->getId(),
    10.00,
    'my description'
);
/** @type Cardinity\Method\Settlement\Settlement */
$result = $client->call($method);
```

### Handling declined settlements
In case settlement could not be processed `Cardinity\Exception\Declined` 
exception will be thrown.

```php
use Cardinity\Exception;
use Cardinity\Method\Settlement;

$method = new Settlement\Create(
    $payment->getId(),
    10.00,
    'fail'
);

try {
    /** @type Cardinity\Method\Settlement\Settlement */
    $settlement = $client->call($method);
} catch (Exception\Declined $exception) {
    /** @type Cardinity\Method\Settlement\Settlement */
    $settlement = $exception->getResult();
    $status = $settlement->getStatus(); // value will be 'declined'
    $errors = $exception->getErrors(); // list of errors occured
}
```

### Get existing settlement
```php
use Cardinity\Method\Settlement;
$method = new Settlement\Get(
    $payment->getId(),
    $settlement->getId()
);
/** @type Cardinity\Method\Settlement\Settlement */
$settlement = $client->call($method);
```

### Get all settlements
```php
use Cardinity\Method\Settlement;
$method = new Settlement\GetAll(
    $payment->getId()
);
$result = $client->call($method);
/** @type Cardinity\Method\Settlement\Settlement */
$settlement = $result[0];
```

## Voids [API](https://developers.cardinity.com/api/v1/#voids)
### Create new void
```php
use Cardinity\Method\Void;
$method = new Void\Create(
    $payment->getId(),
    'my description'
);
/** @type Cardinity\Method\Void\Void */
$result = $client->call($method);
```

### Handling declined voids
In case void could not be processed `Cardinity\Exception\Declined` 
exception will be thrown.

```php
use Cardinity\Exception;
use Cardinity\Method\Void;

$method = new Void\Create(
    $payment->getId(),
    'fail'
);

try {
    /** @type Cardinity\Method\Void\Void */
    $void = $client->call($method);
} catch (Exception\Declined $exception) {
    /** @type Cardinity\Method\Void\Void */
    $void = $exception->getResult();
    $status = $void->getStatus(); // value will be 'declined'
    $errors = $exception->getErrors(); // list of errors occured
}
```

### Get existing void
```php
use Cardinity\Method\Void;
$method = new Void\Get(
    $payment->getId(),
    $void->getId()
);
/** @type Cardinity\Method\Void\Void */
$void = $client->call($method);
```

### Get all voids
```php
use Cardinity\Method\Void;
$method = new Void\GetAll(
    $payment->getId()
);
$result = $client->call($method);
/** @type Cardinity\Method\Void\Void */
$void = $result[0];
```

## Errors
Coming...
