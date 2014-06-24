<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\NotificationService;

/**
 * NotificationServiceTest
 *
 * @author mylittleparis
 */
class NotificationServiceTest extends AbstractTestCase
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

    public function testSendObject()
    {
        $response = $this->getXMLFileMock('sendObjectResponse.xml');

        $uniqueIdentifier = 'uniqueId';
        $securityTag      = 'securityTag';
        $email            = 'name@email.fr';
        $type             = 'INSERT_UPDATE';
        $sendDate         = time();
        $uidKey           = 'email';

        $parameters['sendrequest'] = [
            'email'       => $email,
            'encrypt'     => $securityTag,
            'random'      => $uniqueIdentifier,
            'senddate'    => $sendDate,
            'synchrotype' => $type,
            'uidkey'      => $uidKey,
        ];

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with('sendObject', $parameters)
                ->will($this->returnValue($response))
        ;

        $service = new NotificationService($this->client);

        $this->assertEquals(
            $response,
            $service->sendObject(
                $uniqueIdentifier,
                $securityTag,
                $email,
                null,
                null,
                $type,
                $sendDate,
                $uidKey
            )
        );
    }
}
