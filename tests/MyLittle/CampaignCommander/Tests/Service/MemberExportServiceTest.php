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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createDownloadByMailinglist', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new MemberExportService($this->clientFactory);

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


        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getDownloadStatus', ['id' => '1234'])
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new MemberExportService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getDownloadStatus('1234')
        );
    }

    public function testGetDownloadFile()
    {
        $response = $this->getXMLFileMock('getDownloadFileResponse.xml');

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getDownloadFile', ['id' => '1234'])
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new MemberExportService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getDownloadFile('1234')
        );
    }
}
