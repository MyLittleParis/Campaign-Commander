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

    public function testSegmentationCount()
    {
        $response = $this->getXMLFileMock('segmentationCountResponse.xml');

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with('segmentationCount', ['id' => '1234'])
                ->will($this->returnValue($response))
        ;

        $service = new CcmdSegmentService($this->client);

        $this->assertEquals(
            $response,
            $service->segmentationCount('1234')
        );
    }

    public function testSegmentationDistinctCount()
    {
        $response = $this->getXMLFileMock('segmentationDistinctCountResponse.xml');

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with('segmentationDistinctCount', ['id' => '1234'])
                ->will($this->returnValue($response))
        ;

        $service = new CcmdSegmentService($this->client);

        $this->assertEquals(
            $response,
            $service->segmentationDistinctCount('1234')
        );
    }
}
