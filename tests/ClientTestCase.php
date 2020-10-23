<?php
namespace Cardinity\Tests;

use Cardinity\Client;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Cardinity\Method\Payment;
use PHPUnit\Framework\TestCase;

class ClientTestCase extends TestCase
{
    public function setUp() : void
    {
        $log = Client::LOG_NONE;

        // Use monolog logger to log requests into the file
        // $log = new Logger('requests');
        // $log->pushHandler(new StreamHandler(__DIR__ . '/info.log', Logger::INFO));

        $this->client = Client::create($this->getConfig(), $log);

        $this->assertInstanceOf('Cardinity\Client', $this->client);
    }

    protected function getConfig()
    {
        return [
            'consumerKey' => CONSUMER_KEY,
            'consumerSecret' => CONSUMER_SECRET,
        ];
    }

    protected function getPaymentParams()
    {
        return [
            'amount' => 50.00,
            'currency' => 'EUR',
            'settle' => false,
            'description' => 'some description',
            'order_id' => '12345678',
            'country' => 'LT',
            'payment_method' => Payment\Create::CARD,
            'payment_instrument' => [
                'pan' => '4111111111111111',
                'exp_year' => 2024,
                'exp_month' => 12,
                'cvc' => '456',
                'holder' => 'Mike Dough'
            ],
        ];
    }

    public function getPayment()
    {
        $payment = new Payment\Payment();
        $payment->setId('foo');
        $payment->setType('bar');
        $payment->setCurrency(null);
        $payment->setAmount('55.00');
        $payment->setPaymentMethod(Payment\Create::CARD);
        return $payment;
    }

    
    public function getBrowserInfo()
    {
        $browserInfo = new Payment\BrowserInfo();
        $browserInfo->setAcceptHeader('HTTP accept header.');
        $browserInfo->setBrowserLanguage('cardholder language IETF BCP 47.');
        $browserInfo->setScreenWidth(600);
        $browserInfo->setScreenHeight(400);
        $browserInfo->setChallengeWindowSize("600x400");
        $browserInfo->setUserAgent("agent James Bond");
        $browserInfo->setColorDepth(123);
        $browserInfo->setTimeZone(-60);
        return $browserInfo;
    }

    public function getAddress()
    {
        $address = new Payment\Address();
        $address->setAddressLine1('adress 1');
        $address->setCity('city');
        $address->setCountry('LT');
        $address->setPostalCode('02245');
        return $address;
    }

    public function getThreeDS2DataMandatoryData()
    {
        $treeDS2Data = new Payment\ThreeDS2Data();
        $treeDS2Data->setNotificationUrl('https://notification.url/');

        $browserInfo = $this->getBrowserInfo();
        $treeDS2Data->setBrowserInfo($browserInfo);

        return $treeDS2Data;
    }

    public function getCard()
    {
        $card = new Payment\PaymentInstrumentCard();
        $card->setCardBrand('Visa');
        $card->setPan('4447');
        $card->setExpYear(2023);
        $card->setExpMonth(5);
        $card->setHolder('James Bond');
        return $card;
    }
}
