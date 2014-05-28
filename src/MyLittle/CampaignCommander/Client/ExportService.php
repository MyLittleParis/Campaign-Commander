<?php

namespace MyLittle\CampaignCommander\Client;

/**
 * Export Service
 *
 * @author mylittleparis
 */
class ExportService extends AbstractClient
{
    /**
     * Constructor
     *
     * {@inheritDoc}
     */
    public function __construct($login, $password, $key, $wsdl = self::WSDL_URL_EXPORT, $server = null)
    {
        parent::__construct($login, $password, $key, $wsdl, $server);
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

        $fileID = (int) $this->doCall('createDownloadByMailinglist', $parameters);

        return $fileID;
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
        $parameters = ['id' => (string) $fileID,];

        $status = $this->doCall('getDownloadStatus', $parameters);

        return $status;
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
        $parameters = ['id' => (string) $fileID,];

        $response = $this->doCall('getDownloadFile', $parameters);

        return $response;
    }
}
