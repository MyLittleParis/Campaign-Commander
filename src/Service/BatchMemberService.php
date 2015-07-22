<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientInterface;

/**
 * BatchMemberService
 *
 * @author mylittleparis
 */
class BatchMemberService
{
    /**
     * @var APIClient
     */
    private $apiClient;

    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface $clientFactory
     */
    public function __construct(ClientFactoryInterface $clientFactory)
    {
        $this->apiClient = $clientFactory->createClient(ClientInterface::WSDL_URL_BATCH_MEMBER);

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
     * @param boolean $skipFirstLine
     * @param string $dateFormat
     *
     * @return string The ID of the upload job
     */
    public function uploadFileMerge(
        $fileContent,
        $filename,
        $criteria,
        $mapping,
        $fileEncoding = 'UTF-8',
        $separator = '|',
        $skipFirstLine = false,
        $dateFormat = 'mm/dd/yyyy'
    ) {
        $parameters['file'] = $fileContent;
        $parameters['mergeUpload'] = array(
            'fileName' => (string) $filename,
            'fileEncoding' => (string) $fileEncoding,
            'separator' => (string) $separator,
            'skipFirstLine' => $skipFirstLine,
            'dateFormat' => (string) $dateFormat,
            'criteria' => (string) $criteria,
            'mapping' => $mapping,
        );

        return (string) $this->apiClient->doCall('uploadFileMerge', $parameters);
    }
}
