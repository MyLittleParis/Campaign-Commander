<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientInterface;

/**
 * MemberService
 *
 * @author mylittleparis
 */
class MemberService
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
        $this->apiClient = $clientFactory->createClient(ClientInterface::WSDL_URL_MEMBER);
    }

    /**
     * Retrieves the list of fields (i.e.
     * database column names) available in the Member table.
     *
     * @return array	An array containing all the fields in your member-table
     *
     * @throws \Exception
     */
    public function descMemberTable()
    {
        $response = $this->apiClient->doCall('descMemberTable');

        // if response is not valid
        if (!isset($response->fields)) {
            throw new \Exception('Invalid response');
        }

        $fields = array();
        foreach ($response->fields as $row) {
            $fields[] = [
                'name' => $row->name,
                'type' => strtolower($row->type)
            ];
        }

        return $fields;
    }

    /**
     * Get a member by email-address
     *
     * @param string $email     The email address of the member to retrieve.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getMemberByEmail($email)
    {
        $parameters = ['email' => (string) $email];
        $response = $this->apiClient->doCall('getMemberByEmail', $parameters);

        // sometimes this will return a hash, so grab the first one
        if (is_array($response)) {
            $response = $response[0];
        }

        // if response is not valid
        if (!isset($response->attributes->entry)) {
            throw new \Exception('Invalid response');
        }

        return $this->getAttributesEntry($response);
    }

    /**
     * Uses the member ID to retrieve the details of a member.
     *
     * @param string $id    The ID of the member whose details you want to retrieve..
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getMemberById($id)
    {
        $parameters = ['id' => (string) $id];
        $response = $this->apiClient->doCall('getMemberById', $parameters);

        // if response is not valid
        if (!isset($response->attributes->entry)) {
            throw new \Exception('Invalid response');
        }

        return $this->getAttributesEntry($response);
    }

    /**
     * Retrieves a list of a maximum of 50 members who match the given criteria.
     *
     * @param array $member     A member object containing the criteria.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getListMembersByObj(array $member)
    {
        $parameters = ['member' => $member];
        $response = $this->apiClient->doCall('getListMembersByObj', $parameters);

        // no results
        if (null === $response) {
            return array();
        }

        // if response is not valid
        if (!is_array($response)) {
            throw new \Exception('Invalid response');
        }

        $members = [];
        foreach ($response as $row) {
            // if entry exist
            if (!isset($row->attributes->entry)) {
                continue;
            }

            $members[] = $this->getAttributesEntry($row);
        }

        return $members;
    }

    /**
     * Retrieves all members page by page.
     * Each page contains 10 members.
     *
     * @param int $page     The page number to retrieve.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getListMembersByPage($page)
    {
        $parameters = ['page' => (int) $page];
        $response = $this->apiClient->doCall('getListMembersByPage', $parameters);

        if ($response === null) {
            return array();
        }

        // if response is not valid
        if (!isset($response->list)) {
            throw new \Exception('Invalid response');
        }

        $members = [];
        foreach ($response->list as $row) {
            // if entry exist
            if (!isset($row->attributes->entry)) {
                continue;
            }

            $members[] = $this->getAttributesEntry($row);
        }

        return $members;
    }

    /**
     * Insert a new member, all member-fields will be empty
     *
     * @param string $email     The email addres of the new member.
     *
     * @return string 		The job ID of the update, see getJobStatus().
     *
     * @throws \Exception
     */
    public function insertMember($email)
    {
        $parameters = ['email' => (string) $email];
        $response = (int) $this->apiClient->doCall('insertMember', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        // return the job ID
        return (string) $response;
    }

    /**
     * Updates a given field for a certain user
     *
     * @param string $email     The email address of the member.
     * @param string $field	The field to update.
     * @param mixed  $value	The value with which to update the field.
     *
     * @return string 		The job ID of the update, see getJobStatus().
     *
     * @throws \Exception
     */
    public function updateMember($email, $field, $value)
    {
        $parameters = [
            'email' => (string) $email,
            'field' => (string) $field,
            'value' => $value,
        ];

        $response = $this->apiClient->doCall('updateMember', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        // return the job ID
        return (string) $response;
    }

    /**
     * Insert a new member of updates an existing member
     *
     * @param array            $fields      The fields, as a key-value-pair, that will be updates/inserted.
     * @param string[optional] $email       The email of the member to update/insert.
     * @param string[optional] $id          The id of the member to update/insert.
     *
     * @return string                       The job ID of the update/insertion, see getJobStatus().
     *
     * @throws \Exception
     */
    public function insertOrUpdateMemberByObj($fields, $email = null, $id = null)
    {
        if (null === $email && null === $id) {
            throw new \Exception('Email or id has to be specified');
        }

        $parameters['member'] = [];
        foreach ($fields as $key => $value) {
            $parameters['member']['dynContent']['entry'][] = [
                'key' => $key,
                'value' => $value
            ];
        }

        // memberUID
        if (null !== $email) {
            $parameters['member']['memberUID'] = 'email:' . (string) $email;
        }

        if (null !== $id) {
            $parameters['member']['memberUID'] = (string) $id;
        }

        $response = $this->apiClient->doCall('insertOrUpdateMemberByObj', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        return (string) $response;
    }

    /**
     * Update a member by building a member-object
     *
     * @param array            $fields      The fields, as a key-value-pair, that will be updates/inserted.
     * @param string[optional] $email       The email of the member to update/insert.
     * @param string[optional] $id          The id of the member to update/insert.
     *
     * @return string                       The job ID of the update/insertion, see getJobStatus().
     *
     * @throws \Exception
     */
    public function updateMemberByObj($fields, $email = null, $id = null)
    {
        if ($email === null && $id == null) {
            throw new \Exception('Email or id has to be specified');
        }

        $parameters ['member'] = [];
        foreach ($fields as $key => $value) {
            $parameters['member']['dynContent']['entry'][] = [
                'key' => $key,
                'value' => $value,
            ];
        }

        // memberUID
        if ($email !== null) {
            $parameters['member']['memberUID'] = 'email:' . (string) $email;
        }

        if ($id !== null) {
            $parameters['member']['memberUID'] = (string) $id;
        }

        $response = $this->apiClient->doCall('updateMemberByObj', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        return (string) $response;
    }

    /**
     * Retrieves the job status (i.e. the status of the member insertion or update) using the job ID.
     * Possible return-values are:
     * - Insert: The jobs is busy (I think)
     * - Processing: The job is busy
     * - Processed: The job was processed and is done
     * - Error: Something went wrong, there is no way to see what went wrong.
     * - Job_Done_Or_Does_Not_Exist: the job is done or doesn't exists (anymore).
     *
     * @param string $id    The job ID.
     *
     * @return string       The status of the job.
     *
     * @throws \Exception
     */
    public function getMemberJobStatus($id)
    {
        $possibleResponses = [
            'Insert',
            'Processing',
            'Processed',
            'Error',
            'Job_Done_Or_Does_Not_Exist',
        ];

        $parameters = ['synchroId' => (string) $id];
        $response = $this->apiClient->doCall('getMemberJobStatus', $parameters);

        // if response is not valid
        if (!isset($response->status)) {
            throw new \Exception('Invalid response');
        }
        if (!in_array($response->status, $possibleResponses)) {
            throw new \Exception('Invalid response');
        }

        return (string) $response->status;
    }

    /**
     * Unsubscribes one or more members who match a given email address.
     *
     * @param string $email     The email address.
     *
     * @return string		The job ID of the unjoin, see getJobStatus().
     *
     * @throws \Exception
     */
    public function unjoinMemberByEmail($email)
    {
        $parameters =['email'=> (string) $email];
        $response = $this->apiClient->doCall('unjoinMemberByEmail', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        return (string) $response;
    }

    /**
     * Unsubscribes a member who matches a given ID.
     *
     * @param string $id 	The ID of the member.
     *
     * @return string 		The job ID of the unjoin, see getJobStatus().
     *
     * @throws \Exception
     */
    public function unjoinMemberById($id)
    {
        $parameters = ['memberId' => (string) $id];
        $response = $this->apiClient->doCall('unjoinMemberById', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        return (string) $response;
    }

    /**
     * Unsubscribes a member by object.
     *
     * @param array $member	The member.
     *
     * @return string 		The job ID of the unjoin, see getJobStatus().
     *
     * @throws \Exception
     */
    public function unjoinMemberByObj(array $member)
    {
        $parameters = ['member' => $member];
        $response = $this->apiClient->doCall('unjoinMemberByObj', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        return (string) $response;
    }

    /**
     * Re-subscribes an unsubscribed member using his/her email address.
     * If there are multiple members with the same email address, they will all be re-subscribed.
     * REMARK: The number of rejoins per day is limited to avoid massive rejoins and illegal usage of this method.
     *
     * @param string $email	The email address of the member.
     *
     * @return string 		The job ID of the unjoin, see getJobStatus().
     *
     * @throws \Exception
     */
    public function rejoinMemberByEmail($email)
    {
        $parameters = ['email' => (string) $email];
        $response = $this->apiClient->doCall('rejoinMemberByEmail', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        return (string) $response;
    }

    /**
     * Re-subscribes an unsibscribed member using his/her ID.
     * REMARK: The number of rejoins per day is limited to avoid massive rejoins and illegal usage of this method.
     *
     * @param string $id 	The ID of the member.
     *
     * @return string 		The job ID of the unjoin, see getJobStatus().
     *
     * @throws \Exception
     */
    public function rejoinMemberById($id)
    {
        $parameters = ['memberId' => (string) $id];
        $response = $this->apiClient->doCall('rejoinMemberById', $parameters);

        // if response is not valid
        if ($response == 0) {
            throw new \Exception('Invalid response');
        }

        return (string) $response;
    }

    /**
     * Get the attributes entry of the response
     *
     * @param mixed $response
     *
     * @return array
     */
    protected function getAttributesEntry($response)
    {
        $AttributesEntry = [];
        foreach ($response->attributes->entry as $entry) {
            $key = (string) $entry->key;
            $value = (isset($entry->value)) ? $entry->value : null;

            // convert the DATEJOIN key to timestamp UNIX
            if ($key == 'DATEJOIN' && $value !== null) {
                $value = (int) strtotime($value);
            }

            $AttributesEntry[$key] = $value;
        }

        return $AttributesEntry;
    }
}
