<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Service\BatchMemberService;

/**
 * BatchMemberServiceTest
 *
 * @author mylittleparis
 */
class BatchMemberServiceTest extends \PHPUnit_Framework_TestCase
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

        $this->client = $this->getMockBuilder('MyLittle\CampaignCommander\API\SOAP\ClientWithMTOMAttachments')
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

    public function testUploadFileMerge()
    {
        $response = $this->getXMLFileMock('uploadFileMergeResponse.xml');

        $fileContent  = 'EMAIL|EXTRATEST username@mail.com|0';
        $filename     = 'file.csv';
        $criteria     = 'LOWER(EMAIL)';
        $mapping      = '<mapping>'
                        . '<column>'
                            . '<colNum>1</colNum>'
                            . '<fieldName>EMAIL</fieldName>'
                        . '</column>'
                        . '<column>'
                            . '<colNum>2</colNum>'
                            . '<fieldName>EXTRATEST</fieldName>'
                            . '<toReplace>true</toReplace>'
                        . '</column>'
                        . '</mapping>';
        $fileEncoding = 'UTF-8';
        $separator    = '|';
        $skipFirsLine = false;
        $dateFormat   = 'mm/dd/yyyy';

        $parameters['mergeUpload'] = [
            'fileName'      => $filename,
            'fileEncoding'  => $fileEncoding,
            'separator'     => $separator,
            'skipFirstLine' => $skipFirsLine,
            'dateFormat'    => $dateFormat,
            'criteria'      => $criteria,
            'mapping'       => $mapping,
            'file'          => $fileContent,
        ];

        $this->client
                ->expects($this->once())
                ->method('doCall')
                ->with('uploadFileMerge', $parameters)
                ->will($this->returnValue($response))
        ;

        $service = new BatchMemberService($this->client);

        $this->assertEquals(
            $response,
            $service->uploadFileMerge(
                $fileContent,
                $filename,
                $criteria,
                $mapping,
                $fileEncoding,
                $separator,
                $skipFirsLine,
                $dateFormat
            )
        );
    }
}
