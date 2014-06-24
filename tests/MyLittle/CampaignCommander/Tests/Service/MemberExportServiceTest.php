<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\MemberExportService;

/**
 * MemberExportServiceTest
 *
 * @author mylittleparis
 */
class MemberExportServiceTest extends AbstractTestCase
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

    public function testCreateDownloadByMailinglist()
    {
        $response = $this->getXMLFileMock('createDownloadByMailingListResponse.xml');

        $mailinglistId = '1337';
        $operationType = 'ACTIVE_MEMBERS';
        $fieldSelection = 'EMAIL';
        $fileFormat = 'CSV';
        $dedupFlag = 'true';
        $dedupCriteria = 'EMAIL';
        $keepFirst = 'true';

        $parameters = [
            'mailinglistId'  => $mailinglistId,
            'operationType'  => $operationType,
            'fieldSelection' => $fieldSelection,
            'fileFormat'     => $fileFormat,
            'dedupFlag'      => $dedupFlag,
            'dedupCriteria'  => $dedupCriteria,
            'keepFirst'      => $keepFirst,
        ];

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with('createDownloadByMailinglist', $parameters)
                ->will($this->returnValue($response))
        ;

        $service = new MemberExportService($this->client);

        $this->assertEquals(
            $response,
            $service->createDownloadByMailingList(
                $mailinglistId,
                $operationType,
                $fieldSelection,
                $fileFormat,
                $dedupFlag,
                $dedupCriteria,
                $keepFirst
            )
        );
    }

    public function testGetDownloadStatus()
    {
        $response = $this->getXMLFileMock('getDownloadStatusResponse.xml');

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with('getDownloadStatus', ['id' => '1234'])
                ->will($this->returnValue($response))
        ;

        $service = new MemberExportService($this->client);

        $this->assertEquals(
            $response,
            $service->getDownloadStatus('1234')
        );
    }

    public function testGetDownloadFile()
    {
        $response = $this->getXMLFileMock('getDownloadFileResponse.xml');

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with('getDownloadFile', ['id' => '1234'])
                ->will($this->returnValue($response))
        ;

        $service = new MemberExportService($this->client);

        $this->assertEquals(
            $response,
            $service->getDownloadFile('1234')
        );
    }
}
