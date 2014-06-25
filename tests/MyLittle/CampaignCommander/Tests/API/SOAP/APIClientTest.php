<?php

namespace MyLittle\CampaignCommander\Tests\API\SOAP;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\API\SOAP\APIClient;

/**
 * ApiClientTest
 *
 * @author mylittleparis
 */
class APIClientTest extends AbstractTestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $soapClient;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $server;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->soapClient = $this->getMockBuilder('\BeSimple\SoapClient\SoapClient')
            ->disableOriginalConstructor()
            ->setMethods(['openApiConnection'])
            ->getMock()
        ;

        $this->login    = 'LOGIN';
        $this->password = 'PASSWORD';
        $this->key      = 'KEY';
        $this->server   = 'SERVER';
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
        $response = new \stdClass();
        $response->return = $this->getXMLFileMock('openApiConnectionResponse.xml');

        $loginParameters = [
            'login' => $this->login,
            'pwd'   => $this->password,
            'key'   => $this->key,
        ];

        $this->soapClient
            ->expects($this->once())
            ->method('openApiConnection')
            ->with($loginParameters)
            ->will($this->returnValue($response))
        ;

        $apiClient = new APIClient(
            $this->soapClient,
            $this->login,
            $this->password,
            $this->key,
            $this->server
        );

        $apiClient->openApiConnection();
    }

    public function testOpenApiConnectionWrongCases()
    {
        $loginParameters = [
            'login' => $this->login,
            'pwd'   => $this->password,
            'key'   => $this->key,
        ];

        $this->soapClient
            ->expects($this->once())
            ->method('openApiConnection')
            ->with($loginParameters)
            ->will($this->throwException(new \SoapFault('SoapError', 0)))
        ;

        $this->setExpectedException('\MyLittle\CampaignCommander\Exceptions\WebServiceError');

        $apiClient = new APIClient(
            $this->soapClient,
            $this->login,
            $this->password,
            $this->key,
            $this->server
        );

        $apiClient->openApiConnection();

    }

    public function testDoCallWhithCloseConnection()
    {
        $this->setExpectedException('\LogicException');

        $apiClient = new APIClient(
            $this->soapClient,
            $this->login,
            $this->password,
            $this->key,
            $this->server
        );

        $apiClient->doCall('methodTest', ['id' => '1234']);
    }
}
