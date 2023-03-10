<?php

namespace Cardinity\Tests;

use Cardinity\Exception;
use Cardinity\Method\Chargeback;
use Cardinity\Method\Payment;
use Cardinity\Method\ResultObject;

class ChargebackTest extends ClientTestCase
{
    /**
     * @return void
     */
    public $chargebackId;
    public $paymentId;

    public function setUp(): void
    {
        $this->chargebackId = "";
        $this->paymentId = "";

        parent::setUp();
    }


    /**
     * @return void
     */
    public function testChargebackResultObjectSerialization()
    {
        $chargeback  = new Chargeback\Chargeback();
        $chargeback->setId('foo');
        $chargeback->setAmount('55.00');
        $chargeback->setCurrency('USD');
        $chargeback->setType('chargeback');
        $chargeback->setCreated('baar');
        $chargeback->setLive(true);
        $chargeback->setParentId('lorem');
        $chargeback->setStatus('approved');
        $chargeback->setReason('reason_code: reason_message');
        $chargeback->setDescription('bar');


        $this->assertSame(
            '{"id":"foo","amount":"55.00","currency":"USD","type":"chargeback","created":"baar","live":true,"parent_id":"lorem","status":"approved","reason":"reason_code: reason_message","description":"bar"}',
            $chargeback->serialize()
        );
    }

    /**
     * @return void
     */
    public function testChargebackResultObjectUnserialization()
    {
        $json = '{"id":"foo","amount":"55.00","currency":"USD","type":"chargeback","created":"baar","live":true,"parent_id":"lorem","status":"approved","reason":"reason_code: reason_message","description":"bar"}';

        $chargeback  = new Chargeback\Chargeback();
        $chargeback->unserialize($json);

        $this->assertSame('foo', $chargeback->getId());
        $this->assertSame('bar', $chargeback->getDescription());
        $this->assertSame('USD', $chargeback->getCurrency());
        $this->assertSame(true, $chargeback->getLive());
        $this->assertSame('reason_code: reason_message', $chargeback->getReason());
        $this->assertSame(55.00, $chargeback->getAmount());

    }


    /**
     * Get ALl chargeback
     * @return void
     */
    public function testGetAllChargebacks()
    {

        $method = new Chargeback\GetAll();
        $chargebacks = $this->client->call($method);
        $this->assertIsArray($chargebacks);
    }

    /**
     * Get Chargebacks by parent payment id
     *
     * @return void
     */
    public function testGetAllChargebackForPayment()
    {
        $method = new Payment\Create($this->get3ds2PaymentParams());
        $testPayment = $this->client->call($method);

        $method = new Chargeback\GetAll(10, $testPayment->getId());
        $chargebacks = $this->client->call($method);
        $this->assertIsArray($chargebacks);
    }

    /**
     * Get Specific Chargeback by parent payment id and chargeback id
     *
     * @return void
     */
    /*public function testGetSpecificChargeback()
    {
        $test_cb_id = "816008be-701b-4c4f-a69c-77b1030edc23";
        $test_parent_id = "e7ea294c-5737-4f8d-93fb-3acd003f96f1";

        $method = new Chargeback\Get($test_parent_id, $test_cb_id);
        $chargeback = $this->client->call($method);
        $this->assertInstanceOf('Cardinity\Method\Chargeback\Chargeback', $chargeback);
    }*/

}
