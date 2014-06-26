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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('uploadFileMerge', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new BatchMemberService($this->clientFactory);

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
