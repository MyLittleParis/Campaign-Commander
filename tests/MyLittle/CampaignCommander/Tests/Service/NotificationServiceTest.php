<?php

namespace MyLittle\CampaignCommander\Tests\Service;

/**
 * NotificationServiceTest
 *
 * @author mylittleparis
 */
class NotificationServiceTest
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

    /**
     *
     * @param type $mockName
     * @return type
     * @throws \InvalidArgumentException
     */
    protected function getXMLFileMock($mockName)
    {
        $mockFile = __DIR__.'/../Fixtures/'.$mockName;

        if (!is_file($mockFile) || !is_readable($mockFile)) {
            throw new \InvalidArgumentException("Mock '$mockFile' could not be found.");
        }

        return file_get_contents($mockFile);
    }

    public function testSendObject()
    {
        $response = $this->getXMLFileMock('sendObjectResponse.xml');

        $uniqueIdentifier = 'uniqueId';
        $securityTag      = 'securityTag';
        $email            = 'name@email.fr';
        $dyn              = null;
        $content          = null;
        $type             = 'INSERT_UPDATE';
        $sendDate         = null;
        $uidKey           = 'email';

        $parameters['sendrequest'] = [
            'email'       => $email,
            'encrypt'     => $securityTag,
            'random'      => $uniqueIdentifier,
            'senddate'    => $sendDate,
            'synchrotype' => $type,
            'uidkey'      => $uidKey,
            'dyn'         => $dyn,
            'content'     => $content,
        ];

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with( 'sendObject',
                        $parameters)
                ->will($this->returnValue($response))
        ;

        $service = new MemberExportService($this->client);

        $this->assertEquals(
            $response,
            $service->sendObject( $uniqueIdentifier,
                                  $securityTag,
                                  $email,
                                  $dyn,
                                  $content,
                                  $type,
                                  $sendDate,
                                  $uidKey)
        );
    }
}
