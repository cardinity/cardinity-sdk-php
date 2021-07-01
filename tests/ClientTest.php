<?php

namespace Cardinity\Tests;

use Cardinity\Exception;
use Cardinity\Method\Payment;
use Cardinity\Method\ResultObject;
use Cardinity\Method\Payment\Create;

class ClientTest extends ClientTestCase
{ 
    /**
     * @dataProvider localhostUrlValidationDataProvider
     * @return void
     */
    public function testLocalhostUrlExeptionRised($address, $expected_message)
    {
        $paymentParams = $this->getPaymentParams();
        $threeds2Data = $this->getThreeDS2DataMandatoryData();
        $threeds2Data['notification_url'] = $address;
        $paymentParams['threeds2_data'] = $threeds2Data;
        $method = new Payment\Create($paymentParams);

        $this->expectException(Exception\InvalidAttributeValue::class);
        $this->expectErrorMessage($expected_message);

        $payment = $this->client->call($method);
    }

    /**
     * @return array 
     */
    public function localhostUrlValidationDataProvider()
    {
        return [
            [
                'http://localhost',
                'The url "http://localhost" contains restricted values. Do not use "localhost" or "127.0.0.1".'
            ],[
                'https://localhost',
                'The url "https://localhost" contains restricted values. Do not use "localhost" or "127.0.0.1".'
            ],[
                'http://127.0.0.1',
                'The url "http://127.0.0.1" contains restricted values. Do not use "localhost" or "127.0.0.1".'
            ],[
                'https://127.0.0.1',
                'The url "https://127.0.0.1" contains restricted values. Do not use "localhost" or "127.0.0.1".'
            ]
        ];
    }


    /**
     * @dataProvider protocolUrlValidationDataProvider
     * @return void
     */
    public function testProtocolUrlExeptionRised($address, $expected_message)
    {
        $paymentParams = $this->getPaymentParams();
        $threeds2Data = $this->getThreeDS2DataMandatoryData();
        $threeds2Data['notification_url'] = $address;
        $paymentParams['threeds2_data'] = $threeds2Data;
        $method = new Payment\Create($paymentParams);

        $this->expectException(Exception\InvalidAttributeValue::class);
        $this->expectErrorMessage($expected_message);

        $payment = $this->client->call($method);
    }

    /**
     * @return array 
     */
    public function protocolUrlValidationDataProvider()
    {
        return [
            [
                'ftp://example.com',
                'The protocol of "ftp://example.com" should be "http" or "https".'
            ],[
                'htt://example.com',
                'The protocol of "htt://example.com" should be "http" or "https".'
            ],[
                'f://example.com',
                'The protocol of "f://example.com" should be "http" or "https".'
            ]
        ];
    }

    /**
     * @dataProvider localhostUrlNotStringDataProvider
     * @return void
     */
    public function testLocalhostUrlNotStringExeptionRised($address, $expected_message)
    {
        $paymentParams = $this->getPaymentParams();
        $threeds2Data = $this->getThreeDS2DataMandatoryData();
        $threeds2Data['notification_url'] = $address;
        $paymentParams['threeds2_data'] = $threeds2Data;
        $method = new Payment\Create($paymentParams);

        $this->expectException(Exception\InvalidAttributeValue::class);
        $this->expectErrorMessage($expected_message);

        $payment = $this->client->call($method);
    }

    /**
     * @return array 
     */
    public function localhostUrlNotStringDataProvider()
    {
        return [
            [
                123,
                'This value should be of type string.'
            ],[
                null,
                'This value should not be blank.'
            ],
        ];
    }

}