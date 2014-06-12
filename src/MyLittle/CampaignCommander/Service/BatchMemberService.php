<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * BatchMemberService
 *
 * @author mylittleparis
 */
class BatchMemberService extends AbstractService
{
    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->soapClient = $client;
        $this->soapClient->setWsdl(ClientInterface::WSDL_URL_BATCH_MEMBER);
        $this->soapClient->setServer('http://emvapi.emv3.com');
    }

    /**
     * Upload file merge
     * This method uploads a file containing members and merges them with those in the member table.
     *
     * @param string $fileContent
     * @param string $filename
     * @param string $criteria
     * @param string $mapping
     * @param string $fileEncoding
     * @param string $separator
     * @param boolean $skipFirsLine
     * @param string $dateFormat
     *
     * @return string The ID of the upload job
     */
    public function uploadFileMerge($fileContent,
                                    $filename,
                                    $criteria,
                                    $mapping,
                                    $fileEncoding = 'UTF-8',
                                    $separator = '|',
                                    $skipFirsLine = false,
                                    $dateFormat = 'mm/dd/yyyy')
    {
        $parameters['mergeUpload'] = [
            'fileName' => (string) $filename,
            'fileEncoding' => (string) $fileEncoding,
            'separator' => (string) $separator,
            'skipFirstLine' => $skipFirsLine,
            'dateFormat' => (string) $dateFormat,
            'criteria' => (string) $criteria,
            'mapping' => $mapping,
            'file' => $fileContent,
        ];

        return (string) $this->soapClient->doCall('uploadFileMerge', $parameters);
    }
}
