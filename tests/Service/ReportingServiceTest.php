<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\ReportingService;

/**
 * ReportingServiceTest
 *
 * @author mylittleparis
 */
class ReportingServiceTest extends AbstractTestCase
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

        $this->clientFactory = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface')
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


    public function testGetGlobalReportByCampaignId ()
    {
        $response = (array) $this->getXMLFileMock('getGlobalReportByCampaignIdResponse.xml');

        $campaignId = '1';
	
        $parameters = ['campaignId' => (string) $campaignId];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getGlobalReportByCampaignId', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new ReportingService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getGlobalReportByCampaignId($campaignId)
        );
    }
    
    public function testGetSnapshotReportUrl ()
    {
        $response = (array) $this->getXMLFileMock('getSnapshotReportUrlResponse.xml');

        $campaignId = '1';
	
        $parameters = ['campaignId' => (string) $campaignId];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getSnapshotReportUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new ReportingService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getSnapshotReportUrl($campaignId)
        );
    }
    
    public function testGetLinkReport ()
    {
        $response = (array) $this->getXMLFileMock('getLinkReportResponse.xml');

        $campaignId = '1';
	    $page = 'test';
	
        $parameters = [
            'campaignId' => (string) $campaignId,
            'page' => (int) $page
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getLinkReport', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new ReportingService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getLinkReport($campaignId, $page)
        );
    }   
}