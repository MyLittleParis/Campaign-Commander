<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\BatchMemberService;

/**
 * BatchMemberServiceTest
 *
 * @author mylittleparis
 */
class BatchMemberServiceTest extends AbstractTestCase
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
