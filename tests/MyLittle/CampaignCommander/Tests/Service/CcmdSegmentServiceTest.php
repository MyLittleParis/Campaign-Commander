<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Service\CcmdSegmentService;

/**
 * CcmdSegmentServiceTest
 *
 * @author mylittleparis
 */
class CcmdSegmentServiceTest extends \PHPUnit_Framework_TestCase
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
