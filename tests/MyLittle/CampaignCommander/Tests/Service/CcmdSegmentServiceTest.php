<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdSegmentService;

/**
 * CcmdSegmentServiceTest
 *
 * @author mylittleparis
 */
class CcmdSegmentServiceTest extends AbstractTestCase
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

    public function testSegmentationCount()
    {
        $response = $this->getXMLFileMock('segmentationCountResponse.xml');

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationCount', ['id' => '1234'])
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationCount('1234')
        );
    }

    public function testSegmentationDistinctCount()
    {
        $response = $this->getXMLFileMock('segmentationDistinctCountResponse.xml');

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationDistinctCount', ['id' => '1234'])
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationDistinctCount('1234')
        );
    }
}
