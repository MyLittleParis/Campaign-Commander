<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * ReportingService
 *
 * @author mylittleparis
 */
class ReportingService
{
    /**
     * @var APIClient
     */
    private $apiClient;

    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\Model\ClientFactoryInterface $clientFactory
     */
    public function __construct(ClientFactoryInterface $clientFactory)
    {
        $this->apiClient = $clientFactory->createClient(ClientInterface::WSDL_URL_REPORTING);
    }

    /**
     * Retrieves a campaign Report.
     *
     * @param string $campaignId    The ID of the campaign
     *
     * @return array                The global report of the campaign.
     */
    public function getGlobalReportByCampaignId($campaignId)
    {
        $parameters = ['campaignId' => (string) $campaignId];

        return (array) $this->apiClient->doCall('getGlobalReportByCampaignId', $parameters);
    }

    /**
     * Retrieves the URL of a campaign's snapshot.
     *
     * @param string $campaignId    The ID of the campaign
     *
     * @return array                The global report of the campaign.
     */
    public function getSnapshotReportUrl($campaignId)
    {
        $parameters = ['campaignId' => (string) $campaignId];

        return (array) $this->apiClient->doCall('getSnapshotReportUrl', $parameters);
    }

    /**
     * Retrieves a link report.
     *
     * @param string $campaignId    The ID of the campaign
     * @param int    $page          The page to return
     *
     * @return array                The paginated list of link response reports of the campaign.
     */
    public function getLinkReport($campaignId, $page = 1)
    {
        $parameters = [
            'campaignId' => (string) $campaignId,
            'page' => (int) $page
        ];

        return (array) $this->apiClient->doCall('getLinkReport', $parameters);
    }
}
