<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * ReportingService
 *
 * @author mylittleparis
 */
class ReportingService extends AbstractService
{
    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        parent::__construct($client, ClientInterface::WSDL_URL_REPORTING);
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

        return (array) $this->soapClient->doCall('getGlobalReportByCampaignId',$parameters);
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

        return (array) $this->soapClient->doCall('getSnapshotReportUrl',$parameters);
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

        return (array) $this->soapClient->doCall('getLinkReport',$parameters);
    }
}