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

        $this->client = new \MyLittle\CampaignCommander\API\SOAP\Client(LOGIN, PASSWORD, KEY, SERVER);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->client = null;

        parent::tearDown();
    }

    protected function getSoapClient(array $methods)
    {
        $soapClient = $this->getMockBuilder('MyLittle\CampaignCommander\API\SOAP\Client')
                ->setMethods(array_merge($methods, ['openApiCOnnection']))
                ->setConstructorArgs([__DIR__.'../../Fixtures/batch_member_service.wsdl.xml'])
                ->getMock()
        ;

        $soapClient
            ->expects($this->any())
            ->method('openApiConnection')
            ->will($this->returnValue(__DIR__.'../../Fixtures/openApiConnectionResponse.xml'))
        ;

        return $soapClient;
    }

    public function testCloseApiConnection()
    {
        $soapClientMock = $this->getSoapClient(['closeApiConnection']);

        $soapClientMock
            ->expects($this->any())
            ->method('closeApiConnection')
            ->will($this->returnValue(__DIR__.'../../Fixtures/closeApiConnectionResponse.xml'))
        ;
    }
}
