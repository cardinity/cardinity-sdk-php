<?php

namespace Cardinity\Tests;

use Cardinity\Client;
use PHPUnit\Framework\TestCase;
use Cardinity\Method\Payment;

class ClientEndpointTest extends ClientTestCase
{
    private $baseConfig;
    private $log;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->baseConfig = [
            'consumerKey' => CONSUMER_KEY,
            'consumerSecret' => CONSUMER_SECRET,
        ];
        $this->log = Client::LOG_NONE;
    }

    /**
     * Test create client with invalid URL
     *
     * @return void
     */
    public function testInvalidURLEndpoint(){

        $this->baseConfig['apiEndpoint'] = '123abc';
        try {
            Client::create($this->baseConfig, $this->log);
        } catch (\Exception $e) {
            //throw $th;
            $this->assertStringContainsString('Your API endpoint is not a valid URL', $e->getMessage());
        }
    }

     /**
     * Test create client with valid URL,
     *
     * @return void
     */
    public function testValidUrlWrongEndpoint(){

        $this->baseConfig['apiEndpoint'] = 'https://api.carwash.com/v1/';

        try {
            $client = Client::create($this->baseConfig, $this->log);

            $method = new Payment\Create($this->getPaymentParams());
            $client->call($method);

        } catch (\Exception $e) {
            //throw $th;
            $this->assertStringContainsString('error', $e->getMessage());
        }
        $this->assertInstanceOf('Cardinity\Client', $client);
    }

    /**
     * Test create client with valid URL,
     *
     * @return void
     */
    public function testValidURLValidEndpoint(){

        $this->baseConfig['apiEndpoint'] = 'https://api.cardinity.com/v1/';
        $client = Client::create($this->baseConfig, $this->log);
        $this->assertInstanceOf('Cardinity\Client', $client);
    }

     /**
     * Test create client with valid URL,
     *
     * @return void
     */
    public function testNoEndpoint(){

        unset($this->baseConfig['apiEndpoint']);
        $client = Client::create($this->baseConfig, $this->log);
        $this->assertInstanceOf('Cardinity\Client', $client);
    }
}
