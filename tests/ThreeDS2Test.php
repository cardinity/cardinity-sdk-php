<?php

namespace Cardinity\Tests;

use Cardinity\Exception;
use Cardinity\Method\Payment;
use Cardinity\Method\ResultObject;


class ThreeDS2Test extends ClientTestCase
{
    /**
     * @return void
     */
    public function testClientCallSuccess()
    {
        $threeDS2Data = $this->getThreeDS2Data();

        // $info = new Payment\AuthorizationInformation();
        // $info->setUrl('http://...');
        // $info->setData('some_data');
        // $payment->setAuthorizationInformation($info);
        
        $threeDS2Data = $this->getThreeDS2DataMandatoryData();
        unset($threeDS2Data['notification_url']);
        // $billingAddress = $this->getAddress();
        // $threeDS2Data['billing_address'] = $billingAddress;

        // $payment->setThreeDS2Data($threeDS2Data);
        // $testPayment = $this->ThreeDS2PaymentProvider();
        $method = new Payment\Create([
            'amount' => 59.01,
            'currency' => 'EUR',
            'settle' => true,
            'description' => '3ds2-Testing-for-pass',
            'order_id' => 'orderid123',
            'country' => 'LT',
            'payment_method' => Payment\Create::CARD,
            'payment_instrument' => [
                'pan' => '5454545454545454',
                'exp_year' => date('Y') + 4,
                'exp_month' => 12,
                'cvc' => '456',
                'holder' => 'Shb Mike Dough'
            ],
            'threeds2_data' => $threeDS2Data
        ]);

        try {
            $payment = $this->client->call($method);
            $this->assertEquals('pending', $payment->getStatus());
        } catch (Exception\Declined $exception) {
            $payment = $exception->getResult();
            $status = $payment->getStatus();
            $errors = $exception->getErrors();
        } catch (Exception\ValidationFailed $exception) {
            $payment = $exception->getResult();
            $status = $payment->getStatus();
            $errors = $exception->getErrors();
        } catch (Cardinity\Exception\InvalidAttributeValue $exception) {
            $errors = $exception->getErrors();
        }
        if (isset($errors)) {
            $this->assertContains('[threeds2_data][notification_url]',$errors);
        }
    }
}
