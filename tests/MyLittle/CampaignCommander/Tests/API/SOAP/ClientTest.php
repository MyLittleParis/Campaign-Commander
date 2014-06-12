<?php

namespace MyLittle\CampaignCommander\Tests;

use MyLittle\CampaignCommander\API\SOAP\Client;

/**
 * ApiSoapClientTest
 *
 * @author mylittleparis
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client = new Client(LOGIN, PASSWORD, KEY);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->client = null;

        parent::tearDown();
    }

    public function testCloseApiConnection()
    {
        $response = $this->client->closeApiConnection();
    }

    public function testOpenApiConnection()
    {
        $response = $this->client->openApiConnection();
    }
}
