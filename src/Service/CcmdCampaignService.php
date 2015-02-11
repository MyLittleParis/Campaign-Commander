<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientInterface;

/**
 * CcmdCampaignService
 *
 * @author mylittleparis
 */
class CcmdCampaignService
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
        $this->apiClient = $clientFactory->createClient(ClientInterface::WSDL_URL_CCMD);
    }

    /**
     * Create a campaign.
     *
     * @param  string           $name              Name of the campaign.
     * @param  int              $sendDate          Date for the campaign to be scheduled.
     * @param  string           $messageId         Id of the message to send.
     * @param  string           $mailingListId     Id of the mailing list to be send the campaign to.
     * @param  string[optional] $description       The description.
     * @param  bool[optional]   $notifProgress     Should you be notified of the progress of the campaign by email.
     * @param  bool[optional]   $postClickTracking Use post click tracking?
     * @param  bool[optional]   $emaildedupflg     Deduplicate the mailing list?
     *
     * @return int           The ID of the campaign.
     */
    public function createCampaign(
    $name, $sendDate, $messageId, $mailingListId, $description = null, $notifProgress = false, $postClickTracking = false, $emaildedupflg = false
    )
    {
        $parameters = [
            'name' => (string) $name,
            'sendDate' => date('Y-m-d H:i:s', (int) $sendDate),
            'messageId' => (string) $messageId,
            'mailingListId' => (string) $mailingListId,
            'notifProgress' => (bool) $notifProgress,
            'postClickTracking' => (bool) $postClickTracking,
            'emaildedupflg' => (bool) $emaildedupflg
        ];

        if (null !== $description) {
            $parameters['desc'] = (string) $description;
        }

        return (int) $this->apiClient->doCall('createCampaign', $parameters);
    }

    /**
     * Create a campaign with analytics activated.
     *
     * @param  string           $name              Name of the campaign.
     * @param  int              $sendDate          Date for the campaign to be scheduled.
     * @param  string           $messageId         Id of the message to send.
     * @param  string           $mailingListId     Id of the mailing list to be send the campaign to.
     * @param  string[optional] $description       The description.
     * @param  bool[optional]   $notifProgress     Should you be notified of the progress of the campaign by email.
     * @param  bool[optional]   $postClickTracking Use post click tracking?
     * @param  bool[optional]   $emaildedupflg     Deduplicate the mailing list?
     *
     * @return int           The ID of the campaign.
     */
    public function createCampaignWithAnalytics(
    $name, $sendDate, $messageId, $mailingListId, $description = null, $notifProgress = false, $postClickTracking = false, $emaildedupflg = false
    )
    {
        $parameters = [
            'name' => (string) $name,
            'sendDate' => date('Y-m-d H:i:s', (int) $sendDate),
            'messageId' => (string) $messageId,
            'mailingListId' => (string) $mailingListId,
            'notifProgress' => (bool) $notifProgress,
            'postClickTracking' => (bool) $postClickTracking,
            'emaildedupflg' => (bool) $emaildedupflg
        ];

        if (null !== $description) {
            $parameters['desc'] = (string) $description;
        }

        return (int) $this->apiClient->doCall('createCampaignWithAnalytics', $parameters);
    }

    /**
     * Create a campaign.
     *
     * @param  array  $campaign The campaign object.
     *
     * @return int The ID of the campaign.
     */
    public function createCampaignByObj(array $campaign)
    {
        $parameters = ['campaign' => $campaign];

        return (int) $this->apiClient->doCall('createCampaignByObj', $parameters);
    }

    /**
     * Delete a campaign.
     *
     * @param  string $id The ID of the campaign.
     *
     * @return bool   true if delete was successful.
     */
    public function deleteCampaign($id)
    {
        $parameters = ['id' => (string) $id];

        return (bool) $this->apiClient->doCall('deleteCampaign', $parameters);
    }

    /**
     * Update a campaign.
     *
     * @param  string $id    The ID of the campaign.
     * @param  string $field Field to update.
     * @param  mixed  $value Value to set.
     *
     * @return bool   true of update was successful.
     */
    public function updateCampaign($id, $field, $value)
    {
        $parameters = [
            'id' => (string) $id,
            'field' => (string) $field,
            'value' => $value
        ];

        return (bool) $this->apiClient->doCall('updateCampaign', $parameters);
    }

    /**
     * Update a campaign.
     *
     * @param  array $campaign The campaign object.
     *
     * @return bool  true if the update was successful.
     */
    public function updateCampaignByObj(array $campaign)
    {
        $parameters = ['campaign' => $campaign];

        return (bool) $this->apiClient->doCall('updateCampaignByObj', $parameters);
    }

    /**
     *  Post a campaign.
     *
     * @param  string $id The ID of the campaign.
     *
     * @return bool   true if post was successful.
     */
    public function postCampaign($id)
    {
        $parameters = ['id' => (string) $id];

        return (bool) $this->apiClient->doCall('postCampaign', $parameters);
    }

    /**
     * Unpost a campaign.
     *
     * @param  string $id The ID of the campaign.
     *
     * @return bool   true if unpost was successful.
     */
    public function unpostCampaign($id)
    {
        $parameters = ['id' => (string) $id];

        return (bool) $this->apiClient->doCall('unpostCampaign', $parameters);
    }

    /**
     * Get a campign.
     *
     * @param  string $id The ID of the campaign.
     *
     * @return object The campaign parameters.
     */
    public function getCampaign($id)
    {
        $parameters = ['id' => (string) $id];

        return $this->apiClient->doCall('getCampaign', $parameters);
    }

    /**
     * Get campaigns by field.
     *
     * @param  string $field Field to update.
     * @param  mixed  $value Value to set in that field.
     * @param  int    $limit Maximum number of elements to retrieve.
     *
     * @return array  List of IDS of campaigns matching the search.
     */
    public function getCampaignsByField($field, $value, $limit)
    {
        $parameters = [
            'field' => (string) $field,
            'value' => $value,
            'limit' => (int) $limit
        ];

        return (array) $this->apiClient->doCall('getCampaignsByField', $parameters);
    }

    /**
     * Retrieves a list of campaign having a specified status
     *
     * @param  string $status Status to match, possible values:
     *      EDITABLE, QUEUED, RUNNING, PAUSES, COMPLETED, FAILED, KILLED.
     *
     * @return array  The list of campaign IDs matching the status.
     *
     * @throws \Exception
     */
    public function getCampaignsByStatus($status)
    {
        // List of valid status
        $allowedStatus = [
            'EDITABLE',
            'QUEUED',
            'RUNNING',
            'PAUSES',
            'COMPLETED',
            'FAILED',
            'KILLED'
        ];

        // Check if status is valid
        if (!in_array($status, $allowedStatus)) {
            throw new \Exception(
            'Invalid status (' . $status . '), allowed values are: ' . implode(', ', $allowedStatus) . '.'
            );
        }

        $parameters = ['status' => (string) $status];

        return (array) $this->apiClient->doCall('getCampaignsByStatus', $parameters);
    }

    /**
     * Retrieves a list of campaigns from a specific period.
     *
     * @param  int   $dateBegin The start date of the period.
     * @param  int   $dateEnd   The end date of the period.
     *
     * @return array The list of campaign IDs matching the status.
     */
    public function getCampaignsByPeriod($dateBegin, $dateEnd)
    {
        $parameters = [
            'dateBegin' => date('Y-m-d H:i:s', (int) $dateBegin),
            'dateEnd' => date('Y-m-d H:i:s', (int) $dateEnd)
        ];

        return (array) $this->apiClient->doCall('getCampaignsByPeriod', $parameters);
    }

    /**
     * Get the status for a campaign.
     *
     * @param  string $id The ID of the campaign.
     *
     * @return string Status of the campaign.
     */
    public function getCampaignStatus($id)
    {
        $parameters = ['id' => (string) $id];

        return (string) $this->apiClient->doCall('getCampaignStatus', $parameters);
    }

    /**
     * Get last campaigns
     *
     * @param  int   $limit Maximum number of campaigns to retrieve.
     *
     * @return array        The list of the most recent campaign IDs
     */
    public function getLastCampaigns($limit)
    {
        $parameters = ['limit' => (int) $limit];

        return (array) $this->apiClient->doCall('getLastCampaigns', $parameters);
    }

    /**
     * Sends a test campaign to a group of members.
     *
     * @param  string $id      The ID of the campaign.
     * @param  string $groupId The ID of the group to whom to send the test.
     *
     * @return bool   true if it was successfull, false otherwise.
     */
    public function testCampaignByGroup($id, $groupId)
    {
        $parameters = [
            'id' => (string) $id,
            'groupId' => (string) $groupId
        ];

        return (bool) $this->apiClient->doCall('testCampaignByGroup', $parameters);
    }

    /**
     * Sends a test campaign to a member.
     *
     * @param  string $id       The ID of the campaign.
     * @param  string $memberId The ID of the member to whom to send the test.
     *
     * @return bool   true if it was successfull, false otherwise.
     */
    public function testCampaignByMember($id, $memberId)
    {
        $parameters = [
            'id' => (string) $id,
            'memberId' => (string) $memberId
        ];

        return (bool) $this->apiClient->doCall('testCampaignByMember', $parameters);
    }

    /**
     * Pause a running campaign.
     *
     * @param  string $id The ID of the campaign.
     *
     * @return bool   true if it was successfull, false otherwise.
     */
    public function pauseCampaign($id)
    {
        $parameters = ['id' => (string) $id];

        return (bool) $this->apiClient->doCall('pauseCampaign', $parameters);
    }

    /**
     * Unpauses a paused campaign.
     *
     * @param  string $id The ID of the campaign.
     *
     * @return bool   true if it was successfull, false otherwise.
     */
    public function unpauseCampaign($id)
    {
        $parameters = ['id' => (string) $id];

        return (bool) $this->apiClient->doCall('unpauseCampaign', $parameters);
    }

    /**
     * Retrieves a snapshot report.
     *
     * @param  string $id The id of the campaign.
     *
     * @return array  The campaign snapshot report data.
     */
    public function getCampaignSnapshotReport($id)
    {
        $parameters = ['campaignId' => (string) $id];

        return (array) $this->apiClient->doCall('getCampaignSnapshotReport', $parameters);
    }

}
