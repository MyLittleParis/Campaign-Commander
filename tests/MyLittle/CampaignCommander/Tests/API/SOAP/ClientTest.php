<?php

namespace MyLittle\CampaignCommander\Tests\API\SOAP;

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
        $this->client
            ->expects($this->once())
            ->method('openApiConnection')
            ->will($this->returnValue(__DIR__.'../../Fixtures/openApiConnectionResponse.xml'))
        ;

        $response = $this->client->openApiConnection();
        $this->assertEquals(__DIR__.'../../Fixtures/openApiConnectionResponse.xml', $response);
    }

    public function testCloseApiConnection()
    {
        $this->client
            ->expects($this->once())
            ->method('closeApiConnection')
            ->will($this->returnValue(__DIR__.'../../Fixtures/closeApiConnectionResponse.xml'))
        ;

        $response = $this->client->closeApiConnection();
        $this->assertEquals(__DIR__.'../../Fixtures/closeApiConnectionResponse.xml', $response);
    }
}
