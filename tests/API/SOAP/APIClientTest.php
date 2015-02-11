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
            ->setMethods(['openApiConnection', '__soapCall'])
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

    public function testCloseApiConnection()
    {
        $this->OpenConnection();

        $response = new \stdClass();
        $response->return = 'SUCCESS';

        $method = 'closeApiConnection';

        $this->soapClient
            ->expects($this->once())
            ->method('__soapCall')
            ->with($method)
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
        $apiClient->closeApiConnection();
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

    public function testDoCall()
    {
        $this->OpenConnection();

        $response = new \stdClass();
        $response->return = 'SUCCESS';

        $method = 'methodTest';
        $parameters = ['id' => '1234'];

        $this->soapClient
            ->expects($this->once())
            ->method('__soapCall')
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
        $apiClient->doCall($method, $parameters);
    }

    public function testDoCallWithSoapFaultResponse()
    {
        $this->OpenConnection();

        $method = 'methodTest';
        $parameters = ['id' => '1234'];

        $this->soapClient
            ->expects($this->once())
            ->method('__soapCall')
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
        $apiClient->doCall($method, $parameters);
    }

    private function OpenConnection()
    {
        $response = new \stdClass();
        $response->return = 'TOKEN1234';

        $loginParameters = [
            'login' => $this->login,
            'pwd'   => $this->password,
            'key'   => $this->key,
        ];

        $this->soapClient
            ->expects($this->any())
            ->method('openApiConnection')
            ->with($loginParameters)
            ->will($this->returnValue($response))
        ;
    }
}
