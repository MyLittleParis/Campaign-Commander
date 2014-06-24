<?php

namespace MyLittle\CampaignCommander\Tests\API\SOAP;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Exceptions\WebServiceError;

/**
 * ApiSoapClientTest
 *
 * @author mylittleparis
 */
class ClientTest extends AbstractTestCase
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

        $this->client = $this->getMockBuilder('MyLittle\CampaignCommander\API\SOAP\Client')
                ->disableOriginalConstructor()
                ->getMock()
        ;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->client = null;

        parent::tearDown();
    }

    public function testOpenApiConnection()
    {
        $response = $this->getXMLFileMock('openApiConnectionResponse.xml');

        $this->client
                ->expects($this->once())
                ->method('openApiConnection')
                ->will($this->returnValue($response))
        ;

        $this->assertEquals(
            $response,
            $this->client->openApiConnection()
        );
    }

    public function testCloseApiConnection()
    {
        $response = $this->getXMLFileMock('openApiConnectionResponse.xml');

        $this->client
                ->expects($this->once())
                ->method('closeApiConnection')
                ->will($this->returnValue($response))
        ;

        $this->assertEquals(
            $response,
            $this->client->closeApiConnection()
        );
    }
}
