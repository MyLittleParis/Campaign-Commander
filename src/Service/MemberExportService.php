<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientInterface;

/**
 * Export Service
 *
 * @author mylittleparis
 */
class MemberExportService
{
    const DOWNLOAD_SUCCESS = 'OK';
    const DOWNLOAD_EMPTY = 'NO_DATA';
    const DOWNLOAD_NOT_READY = 'NOT_YET_READY';
    const DOWNLOAD_ERROR = 'ERROR';

    const EXPORT_VALIDATED = 'VALIDATED';
    const EXPORT_RUNNING = 'RUNNING';
    const EXPORT_SUCCESS = 'SUCCESS';
    const EXPORT_ERROR = 'ERROR';
    const EXPORT_DELETED = 'DELETED';

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
        $this->apiClient = $clientFactory->createClient(ClientInterface::WSDL_URL_EXPORT);
    }

    /**
     * Get download file status list
     *
     * @return array
     */
    public function getDownloadStatusList()
    {
        return [
            self::DOWNLOAD_EMPTY,
            self::DOWNLOAD_NOT_READY,
            self::DOWNLOAD_SUCCESS,
            self::DOWNLOAD_ERROR
        ];
    }

    /**
     * Get export file status list
     *
     * @return array
     */
    public function getExportFileStatusList()
    {
        return [
            self::EXPORT_VALIDATED,
            self::EXPORT_RUNNING,
            self::EXPORT_SUCCESS,
            self::EXPORT_ERROR,
            self::EXPORT_DELETED
        ];
    }

    /**
     * Create download by mailing list
     * Retrieves a list of members from a segment given.
     *
     * @param string $segmentID
     * @param string $operationType
     * @param string $fieldSelection
     * @param string $fileFormat
     * @param string $dedupFlag
     * @param string $dedupCriteria
     * @param string $keepFirst
     *
     * @return string                      The ID of the export request
     */
    public function createDownloadByMailinglist(
        $segmentID,
        $operationType,
        $fieldSelection,
        $fileFormat,
        $dedupFlag,
        $dedupCriteria,
        $keepFirst
    ) {
        $parameters = [
            'mailinglistId' => (string) $segmentID,
            'operationType' => (string) $operationType,
            'fieldSelection' => (string) $fieldSelection,
            'fileFormat' => (string) $fileFormat,
            'dedupFlag' => (string) $dedupFlag,
            'dedupCriteria' => (string) $dedupCriteria,
            'keepFirst' => (string) $keepFirst,
        ];

        return (string) $this->apiClient->doCall('createDownloadByMailinglist', $parameters);
    }

    /**
     * Get the download status
     *
     * @param string $fileID    The ID of the export request
     *
     * @return string
     */
    public function getDownloadStatus($fileID)
    {
        $parameters = ['id' => (string) $fileID];

        return (string) $this->apiClient->doCall('getDownloadStatus', $parameters);
    }

    /**
     * Get the content of the download file
     *
     * @param type $fileID      The ID of the export request
     *
     * @return string
     */
    public function getDownloadFile($fileID)
    {
        $parameters = ['id' => (string) $fileID];

        return (string) $this->apiClient->doCall('getDownloadFile', $parameters);
    }
}
