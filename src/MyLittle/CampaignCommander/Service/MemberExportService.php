<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * Export Service
 *
 * @author mylittleparis
 */
class MemberExportService extends AbstractService
{
    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->soapClient = $client;
        $this->soapClient->setWsdl(ClientInterface::WSDL_URL_EXPORT);
        $this->soapClient->setServer('http://emvapi.emv3.com');
    }

    /**
     * Create download by mailing list
     * Retrieves a list of members from a segment given.
     *
     * @param type $segmentID
     * @param type $operationType
     * @param type $fieldSelection
     * @param type $fileFormat
     * @param type $dedupFlag
     * @param type $dedupCriteria
     * @param type $keepFirst
     *
     * @return int                      The ID of the export request
     */
    public function createDownloadByMailinglist($segmentID,
                                                $operationType,
                                                $fieldSelection,
                                                $fileFormat,
                                                $dedupFlag,
                                                $dedupCriteria,
                                                $keepFirst)
    {
        $parameters = [
            'mailinglistId' => (string) $segmentID,
            'operationType' => (string) $operationType,
            'fieldSelection' => (string) $fieldSelection,
            'fileFormat' => (string) $fileFormat,
            'dedupFlag' => (string) $dedupFlag,
            'dedupCriteria' => (string) $dedupCriteria,
            'keepFirst' => (string) $keepFirst,
        ];

        return (int) $this->soapClient->doCall('createDownloadByMailinglist', $parameters);
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

        return (string) $this->soapClient->doCall('getDownloadStatus', $parameters);
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

        return (string) $this->soapClient->doCall('getDownloadFile', $parameters);
    }
}
