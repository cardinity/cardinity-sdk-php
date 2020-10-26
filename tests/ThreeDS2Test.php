<?php

namespace Cardinity\Tests;

use Cardinity\Exception;
use Cardinity\Method\Payment;
use Cardinity\Method\ResultObject;


class ThreeDS2Test extends ClientTestCase
{
    public function testBrowserInfoObject()
    {
        $browserInfo = $this->getBrowserInfo();
        $this->assertInstanceOf('Cardinity\Method\Payment\BrowserInfo', $browserInfo);
    }

    public function testBrowserInfoParams()
    {
        $browserInfo = $this->getBrowserInfo();
        $testBrowserInfo = $this->browserInfoProvider();
        foreach ($browserInfo as $k => $v) $this->assertEquals($v, $testBrowserInfo[$k]);
    }

    /**
     * @dataProvider optionalBrowserInfoProvider
     */
    public function testBrowserInfoOptionalParams($args)
    {
        $browserInfo = $this->getBrowserInfo($args);
        $testBrowserInfo = $this->browserInfoProvider($args);
        foreach ($browserInfo as $k => $v) $this->assertEquals($v, $testBrowserInfo[$k]);
    }

    public function optionalBrowserInfoProvider()
    {
        return [
            [['ip_address' => '0.0.0.0']],
            [['javascript_enabled' => false]],
            [['javascript_enabled' => true]],
            [['java_enabled' => false]],
            [['java_enabled' => true]],
            [['ip_address' => '0.0.0.0', 'javascript_enabled' => true]],
            [['ip_address' => '0.0.0.0', 'java_enabled' => true]],
            [['ip_address' => '0.0.0.0', 'java_enabled' => false, 'javascript_enabled' => true]],
            [['java_enabled' => false, 'javascript_enabled' => true]],
        ];
    }

    public function testAddressObject()
    {
        $address = $this->getAddress();
        $this->assertInstanceOf('Cardinity\Method\Payment\Address', $address);
    }

    public function testAddressObjectParams()
    {
        $address = $this->getAddress();
        $testAddr = $this->addressProvider();
        foreach ($address as $k => $v) $this->assertEquals($v, $testAddr[$k]);
    }

    /**
     * @dataProvider optionalAddressProvider
     */
    public function testAddressObjectOptionalParams($args)
    {
        $address = $this->getAddress($args);
        $testAddr = $this->addressProvider($args);
        // print_r($testAddr);exit;
        foreach ($address as $k => $v) $this->assertEquals($v, $testAddr[$k]);
    }


    public function optionalAddressProvider()
    {
        return [
            [['address_line2' => 'address line 2']],
            [['address_line3' => 'address line 3']],
            [['state' => 'vilnius']],
            [['address_line2' => 'address line 2', 'state' => 'vilnius']],
        ];
    }
    public function testThreeDS2DataObject()
    {
        $treeDS2Data = $this->getThreeDS2DataMandatoryData();
        $this->assertInstanceOf('Cardinity\Method\Payment\ThreeDS2Data', $treeDS2Data);
    }

    public function testThreeDS2DataParams()
    {
        $treeDS2Data = $this->getThreeDS2DataMandatoryData();
        $test3DS2Data = $this->ThreeDS2DataProvider();

        foreach ($treeDS2Data as $key => $val) {
            if (!is_object($val)) $this->assertEquals($val, $test3DS2Data[$key]);
            elseif ($val) {
                foreach ($val as $k => $v)
                    if ($v) $this->assertEquals($v, $test3DS2Data[$k]);
            }
        }
    }

    public function testThreeDS2PaymentParams()
    {
        $payment = $this->getPayment();
        $card = $this->getCard();
        $payment->setPaymentInstrument($card);

        $info = new Payment\AuthorizationInformation();
        $info->setUrl('http://...');
        $info->setData('some_data');
        $payment->setAuthorizationInformation($info);
        
        $treeDS2Data = $this->getThreeDS2DataMandatoryData();

        $browserInfo = $this->getBrowserInfo();
        $treeDS2Data->setBrowserInfo($browserInfo);

        $billingAddress = $this->getAddress();
        $treeDS2Data->setBillingAddress($billingAddress);

        $payment->setThreeDS2Data($treeDS2Data);

        $testPayment = $this->ThreeDS2PaymentProvider();

        foreach ($payment as $key => $val) {
            if (!is_object($val)) $this->assertEquals($val, $testPayment[$key]);
            elseif ($val) {
                foreach ($val as $k => $v)
                    if ($v) $this->assertEquals($v, $testPayment[$k]);
            }
        }
    }

    public function ThreeDS2PaymentProvider()
    {
        $paymentArr = $this->getPaymentParams();
        $paymentArr['threeds2_data'] = $this->ThreeDS2DataProvider();
        return $paymentArr;
    }
    
    public function ThreeDS2DataProvider(array $args = [])
    {
        $data = [
            "notification_url"=>"https:\/\/notification.url\/",
            "browser_info"=> $this->browserInfoProvider()
        ];
        if ($args) array_push($data, $args);

        return $data;
    }

    public function addressProvider(array $args = [])
    {
        $address = [
            "address_line1"=>"adress 1",
            "city"=>"city",
            "country"=>"LT",
            "postal_code"=>"02245"
        ];
        if ($args) foreach ($args as $k => $v) $address[$k] = $v;

        return $address;
    }

    public function browserInfoProvider(array $args = [])
    {
        $info = [
            "accept_header"=>"HTTP accept header.",
            "browser_language"=>"cardholder language IETF BCP 47.",
            "screen_width"=>600,
            "screen_height"=>400,
            "challenge_window_size"=>"600x400",
            "user_agent"=>"agent James Bond",
            "color_depth"=>24,
            "time_zone"=>-60
        ];
        if ($args) foreach ($args as $k => $v) $info[$k] = $v;
        return $info;
    }
}