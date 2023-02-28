
Cardinity Client PHP Library
================================================
[![Build Status](https://app.travis-ci.com/cardinity/cardinity-sdk-php.svg?branch=master)](https://app.travis-ci.com/cardinity/cardinity-sdk-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cardinity/cardinity-sdk-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cardinity/cardinity-sdk-php/?branch=master)

This is official PHP client library for [Cardinity's](https://developers.cardinity.com/api/v1/) API.  
Library includes all the functionality provided by API. Library was designed to be flexible and self-explanatory for developers to implement.

## Documentation
More detailed documentation with usage examples can be found [here](https://github.com/cardinity/cardinity-sdk-php/tree/master/docs).

## Usage
### Installing via [Composer](https://getcomposer.org)
```bash
$ php composer.phar require cardinity/cardinity-sdk-php
```
### Direct Download
You can download the [latest release](https://github.com/cardinity/cardinity-sdk-php/releases/latest) file starting with ```cardinity-sdk-php-*.zip```.

### Making API Calls
#### Initialize the client object
```php
use Cardinity\Client;
$client = Client::create([
    'consumerKey' => 'YOUR_CONSUMER_KEY',
    'consumerSecret' => 'YOUR_CONSUMER_SECRET',
]);
```

#### Create new payment
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
        'exp_year' => 2021,
        'exp_month' => 12,
        'cvc' => '456',
        'holder' => 'Mike Dough'
    ],
    'threeds2_data' =>  [
        "notification_url" => "your_shop_url_for_handling_callback", 
        "browser_info" => [
            "accept_header" => "text/html",
            "browser_language" => "en-US",
            "screen_width" => 600,
            "screen_height" => 400,
            'challenge_window_size' => "600x400",
            "user_agent" => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0",
            "color_depth" => 24,
            "time_zone" => -60
        ],
    ],
]);
```
#### All the `threeds2_data` parameters should be set dynamically.
Parameters `screen_width`, `screen_height`, `browser_language`, `color_depth`, `time_zone` of `browser_info` could be collected dynamically using `javascript`:
```javascript
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("screen_width").value = screen.availWidth;
    document.getElementById("screen_height").value = screen.availHeight;
    document.getElementById("browser_language").value = navigator.language;
    document.getElementById("color_depth").value = screen.colorDepth;
    document.getElementById("time_zone").value = new Date().getTimezoneOffset();
});
```
and placed into a `html` form
```html
<!-- ... -->
<input type='hidden' id='screen_width' name='screen_width' value='' />                
<input type='hidden' id='screen_height' name='screen_height' value='' />                
<input type='hidden' id='browser_language' name='browser_language' value='' />                
<input type='hidden' id='color_depth' name='color_depth' value='' />                
<input type='hidden' id='time_zone' name='time_zone' value='' />
<!-- ... -->
```
Then call to Cardinity API should be executed using `try ... catch` blocks:
```php
$errors = [];
try {
    /** @type Cardinity\Method\Payment\Payment */
    $payment = $client->call($method);
    $status = $payment->getStatus();
    if ($status == 'approved') {
        echo '<p>Your payment approved without 3D secure.</p>';
    } elseif ($status == 'pending') {
        if ($payment->isThreedsV2()) {
            // $auth object for data required to finalize payment
            $auth = $payment->getThreeds2Data();
            // finalize process should be done here.
        }else if ($payment->isThreedsV1()) {
            // $auth object for data required to finalize payment
            $auth = $payment->getAuthorizationInformation();
            // finalize process should be done here.
        }
    }
} catch (Cardinity\Exception\InvalidAttributeValue $exception) {
    foreach ($exception->getViolations() as $key => $violation) {
        array_push($errors, $violation->getPropertyPath() . ' ' . $violation->getMessage());
    }
} catch (Cardinity\Exception\ValidationFailed $exception) {
    foreach ($exception->getErrors() as $key => $error) {
        array_push($errors, $error['message']);
    }
} catch (Cardinity\Exception\Declined $exception) {
    foreach ($exception->getErrors() as $key => $error) {
        array_push($errors, $error['message']);
    }
} catch (Cardinity\Exception\NotFound $exception) {
    foreach ($exception->getErrors() as $key => $error) {
        array_push($errors, $error['message']);
    }
} catch (Exception $exception) {
    $errors = [$exception->getMessage()];
}
if ($errors) {
    print_r($errors);
}
```
#### Finalize payment
To finalize payment it should have status `pending`. Data received from 3D secure system should be used to create Finalize `$method`.
```php
use Cardinity\Method\Payment;

$client = Client::create([
    'consumerKey' => 'YOUR_CONSUMER_KEY',
    'consumerSecret' => 'YOUR_CONSUMER_SECRET',
]);

if($v2){
    $method = new Payment\Finalize(
        $payment->getId(), // payment object received from API call
        $auth->getCreq(), // payment object received from API call
        true // BOOL `true` to enable 3D secure V2 parameters
    );
}elseif($v1){
    $method = new Payment\Finalize(
        $payment->getId(), // payment object received from API call
        $auth->getData(), // payment object received from API call
        false // BOOL `false` to enable 3D secure V1 parameters
    );
}

// again use same try ... catch block
try {
    $payment = $client->call($method);
}
// same catch blocks ...
// ...

```

#### Get existing payment
```php
$method = new Payment\Get('cb5e1c95-7685-4499-a2b1-ae0f28297b92');
/** @type Cardinity\Method\Payment\Payment */
$payment = $client->call($method);
```

#### Payment Link
To create a payment link you have to create a new payment link object. You can retrieve individual payment links and update payment link parameters. Payment links are identified by a UUID.

#### Create Payment Link
```php
use Cardinity\Method\PaymentLink;

$client = Client::create([
    'consumerKey' => 'YOUR_CONSUMER_KEY',
    'consumerSecret' => 'YOUR_CONSUMER_SECRET',
]);

$method = new PaymentLink\Create([
    'amount' => 50.00,
    'currency' => "USD",
    'description' => "Short description for the payment link",
]);


//with optional parameters
$method = new PaymentLink\Create([
    'amount' => 50.00,
    'currency' => "USD",
    'description' => "Short description for the payment link",

    'country' => "LT", // ISO 3166-1 alpha-2 country code.
    'expiration_date' => "2023-01-06T15:26:03.702Z", //ISO 8601 datetime in UTC 
    'multiple_use' => true, //bool
]);

// again use same try ... catch block
try {
    $paymentLink = $client->call($method);
}
// same catch blocks ...
// ...

```


#### Get Payment Link
```php
use Cardinity\Method\PaymentLink;

$client = Client::create([
    'consumerKey' => 'YOUR_CONSUMER_KEY',
    'consumerSecret' => 'YOUR_CONSUMER_SECRET',
]);

$method = new PaymentLink\Get($linkid);

// again use same try ... catch block
try {
    $paymentLink = $client->call($method);
}
// same catch blocks ...
// ...

```


#### Create Payment Link
```php
use Cardinity\Method\PaymentLink;

$client = Client::create([
    'consumerKey' => 'YOUR_CONSUMER_KEY',
    'consumerSecret' => 'YOUR_CONSUMER_SECRET',
]);

$method = new PaymentLink\Update(
    $payment_link_id,
    [
        'expiration_date' => "2023-01-06T15:26:03.702Z", //ISO 8601 datetime in UTC 
        'enabled' => true,  // true or false
    ]
);

// again use same try ... catch block
try {
    $updatedPaymentLink = $client->call($method);
}
// same catch blocks ...
// ...

```

## API documentation
[https://developers.cardinity.com/api/v1/](https://developers.cardinity.com/api/v1/)

## Development Status
All the API __v1__ methods are implemented.

### Tests
for windows `php vendor/phpunit/phpunit/phpunit`
