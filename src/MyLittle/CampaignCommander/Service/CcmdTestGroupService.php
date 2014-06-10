<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * CcmdService
 *
 * @author mylittleparis
 */
class CcmdTestGroupService extends AbstractService
{
    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->soapClient = $client;
        $this->soapClient->setWsdl(ClientInterface::WSDL_URL_CCMD);
        $this->soapClient->setServer('http://emvapi.emv3.com');
    }

    /**
     * Creates a test group of members.
     *
     * @param  string $name The name of the test group.
     *
     * @return string The ID of the newly created test group.
     */
    public function createTestGroup($name)
    {
        $parameters = ['Name' => (string) $name];

        return (string) $this->soapClient->doCall('createTestGroup', $parameters);
    }

    /**
     * Creates a test group.
     *
     * @param  array  $testGroup The test group object.
     *
     * @return string The ID of the created test group.
     */
    public function createTestGroupByObj(array $testGroup)
    {
        $parameters = ['testGroup' => $testGroup];

        return (string) $this->soapClient->doCall('createTestGroupByObj', $parameters);
    }

    /**
     * Adds a member to a test group.
     *
     * @param  string $memberId The ID of the member to add.
     * @param  string $groupId  The ID of the group to which to add the member.
     *
     * @return bool   true if it was successfull, false otherwise.
     */
    public function addTestMember($memberId, $groupId)
    {
        $parameters = [
            'memberId' => (string) $memberId,
            'groupId' => (string) $groupId
        ];

        return (bool) $this->soapClient->doCall('addTestMember', $parameters);
    }

    /**
     * Removes a member from a test group
     *
     * @param  string $memberId The ID of the member to add.
     * @param  string $groupId  The ID of the group to which to add the member.
     *
     * @return bool   true if it was successfull, false otherwise.
     */
    public function removeTestMember($memberId, $groupId)
    {
        $parameters = [
            'memberId' => (string) $memberId,
            'groupId' => (string) $groupId
        ];

        return (bool) $this->soapClient->doCall('removeTestMember', $parameters);
    }

    /**
     * Deletes a test group.
     *
     * @param  string $groupId The ID of the group to which to add the member.
     *
     * @return bool   true if it was successfull, false otherwise.
     */
    public function deleteTestGroup($groupId)
    {
        $parameters = ['id' => (string) $groupId];

        return (bool) $this->soapClient->doCall('deleteTestGroup', $parameters);
    }

    /**
     * Updates a test group.
     *
     * @param  array $testGroup The test group object.
     *
     * @return bool  true if it was successfull, false otherwise.
     */
    public function updateTestGroupByObj(array $testGroup)
    {
        $parameters = ['testGroup' => $testGroup];

        return (bool) $this->soapClient->doCall('updateTestGroupByObj', $parameters);
    }

    /**
     * Retrieves the list of members in a test group.
     *
     * @param  string $groupId The ID fo the group.
     *
     * @return array The list of member ID's in that group
     */
    public function getTestGroup($groupId)
    {
        $parameters = ['id' => (string) $groupId];

        return (array) $this->soapClient->doCall('getTestGroup', $parameters);
    }

    /**
     * Retrieves a list of test groups.
     *
     * @return array The list of groups IDs.
     */
    public function getClientTestGroups()
    {
        return (array) $this->soapClient->doCall('getClientTestGroups');
    }
}
