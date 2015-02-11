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
     * @var ClientFactoryInterface
     */
    private $clientFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->clientFactory = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\Model\ClientFactoryInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->clientFactory = null;

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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient->expects($this->once())
            ->method('doCall')
            ->with('sendObject', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new NotificationService($this->clientFactory);

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
