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
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->soapClient = $this->getMockBuilder('\BeSimple\SoapClient\SoapClient')
            ->disableOriginalConstructor()
            //->setMethods(['openApiConnection', '__soapCall'])
            ->getMock()
        ;

        $this->login    = 'LOGIN';
        $this->password = 'PASSWORD';
        $this->key      = 'KEY';
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->client = null;

        parent::tearDown();
    }

    public function testDoCall()
    {
        $loginParameters = [
            'login' => $this->login,
            'pwd'   => $this->password,
            'key'   => $this->key,
        ];
        $loginResponse = new \stdClass();
        $loginResponse->return = 'TOKEN1234';
        $this->soapClient
            ->expects($this->at(0))
            ->method('__soapCall')
            ->with('openApiConnection', $loginParameters)
            ->will($this->returnValue($loginResponse))
        ;

        $response = new \stdClass();
        $response->return = 'SUCCESS';

        $method = 'methodTest';
        $parameters = ['id' => '1234'];

        $this->soapClient
            ->expects($this->at(1))
            ->method('__soapCall')
            ->with('methodTest', ['id' => '1234', 'token' => 'TOKEN1234'])
            ->will($this->returnValue($response))
        ;

        $apiClient = new APIClient(
            $this->soapClient,
            $this->login,
            $this->password,
            $this->key
        );

        $apiClient->doCall($method, $parameters);
    }

    public function testDoCallWithSoapFaultResponse()
    {
        $loginParameters = [
            'login' => $this->login,
            'pwd'   => $this->password,
            'key'   => $this->key,
        ];
        $loginResponse = new \stdClass();
        $loginResponse->return = 'TOKEN1234';
        $this->soapClient
            ->expects($this->at(0))
            ->method('__soapCall')
            ->with('openApiConnection', $loginParameters)
            ->will($this->returnValue($loginResponse))
        ;

        $method = 'methodTest';
        $parameters = ['id' => '1234'];

        $this->soapClient
            ->expects($this->at(1))
            ->method('__soapCall')
            ->will($this->throwException(new \SoapFault('SoapError', 0)))
        ;

        $this->setExpectedException('\MyLittle\CampaignCommander\API\SOAP\APIException');

        $apiClient = new APIClient(
            $this->soapClient,
            $this->login,
            $this->password,
            $this->key
        );

        $apiClient->doCall($method, $parameters);
    }
}
