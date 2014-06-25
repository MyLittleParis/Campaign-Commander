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
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $soapClient;

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

        $this->soapClient = $this->getMockBuilder('\SoapClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->client = new \MyLittle\CampaignCommander\API\SOAP\Client();
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

    public function testOpenApiConnectionWrongCases()
    {
        $soapClient
            ->expects($this->any())
            ->method('openApiConnection')
            ->will($this->throwException(new \SoapFault('SoapError', 0)))
        ;

        $this->setExpectedException('MyLittle\CampaignCommander\Exceptions\WebServiceError');

        $this->client->openApiConnection();

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
