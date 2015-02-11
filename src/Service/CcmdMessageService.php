<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientInterface;

/**
 * CcmdMessageService
 *
 * @author mylittleparis
 */
class CcmdMessageService
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
     * Create email-message.
     *
     * @param  string           $name          Name of the message.
     * @param  string           $description   Description of the message.
     * @param  string           $subject       Subject of the message.
     * @param  string           $from          From name.
     * @param  string           $fromEmail     From email-address.
     * @param  string           $to            To name.
     * @param  string           $body          Body of the email.
     * @param  string           $encoding      Encoding to use.
     * @param  string           $replyTo       Reply-to name.
     * @param  string           $replyToEmail  Reply-to email.
     * @param  bool[optional]   $bounceback    Use as bounceback message?
     * @param  bool[optional]   $unsubscribe   Use unsubscribe feature of Windows Live Mail.
     * @param  string[optional] $unsublinkpage Unjoin URL, imporve deliverability displaying a unsubscribe
     *                                         button in Windows Live Mail.
     *
     * @return string           The message ID.
     */
    public function createEmailMessage(
        $name,
        $description,
        $subject,
        $from,
        $fromEmail,
        $to,
        $body,
        $encoding,
        $replyTo,
        $replyToEmail,
        $bounceback = false,
        $unsubscribe = false,
        $unsublinkpage = null
    ) {
        $parameters =[
            'name' => (string) $name,
            'description' => (string) $description,
            'subject' => (string) $subject,
            'from' => (string) $from,
            'fromEmail' => (string) $fromEmail,
            'to' => (string) $to,
            'body' => (string) $body,
            'encoding' => (string) $encoding,
            'replyTo' => (string) $replyTo,
            'replyToEmail' => (string) $replyToEmail,
            'isBounceback' => ($bounceback) ? '1' : '0',
            'hotmailUnsubFlg' => ($unsubscribe) ? '1' : '0'
        ];

        if (null !== $unsublinkpage) {
            $parameters['hotmailUnsubUrl'] = (string) $unsublinkpage;
        }

        return (string) $this->apiClient->doCall('createEmailMessage', $parameters);
    }

    /**
     * Create email-message.
     * @remark  you have to specify an id-element width value 0.
     *
     * @param  array  $message The message object.
     *
     * @return string The message ID.
     */
    public function createEmailMessageByObj($message)
    {
        $parameters = ['message' => $message ];

        return (string) $this->apiClient->doCall('createEmailMessageByObj', $parameters);
    }

    /**
     * Create SMS-message.
     *
     * @param  string $name Name of the message.
     * @param  string $desc Description of the message.
     * @param  string $from From name.
     * @param  string $body Body of the SMS.
     *
     * @return string The message ID.
     */
    public function createSmsMessage($name, $desc, $from, $body)
    {
        $parameters = [
            'name' => (string) $name,
            'desc' => (string) $desc,
            'from' => (string) $from,
            'body' => (string) $body
        ];

        return (string) $this->apiClient->doCall('createSmsMessage', $parameters);
    }

    /**
     * Create SMS-message.
     * @remark  you have to specify an id-element width value 0.
     *
     * @param  array  $message The message object.
     *
     * @return string The message ID.
     */
    public function createSmsMessageByObj(array $message)
    {
        $parameters = ['message' => $message ];

        return (string) $this->apiClient->doCall('createSmsMessageByObj', $parameters);
    }

    /**
     * Delete message.
     *
     * @param  string $id ID of the message.
     *
     * @return bool   true if delete was successful.
     */
    public function deleteMessage($id)
    {
        $parameters = ['id' => $id];

        return (bool) $this->apiClient->doCall('deleteMessage', $parameters);
    }

    /**
     * Update a message field.
     *
     * @param  string $id    ID of the message.
     * @param  string $field The field to update.
     * @param  mixed  $value The value to set.
     *
     * @return bool   true if the update was successful.
     */
    public function updateMessage($id, $field, $value)
    {
        $parameters = [
            'id' => (string) $id,
            'field' => (string) $field,
            'value' => $value
        ];

        return (bool) $this->apiClient->doCall('updateMessage', $parameters);
    }

    /**
     * Update email-message.
     *
     * @param  array $message The message object.
     *
     * @return bool  true if the update was successful.
     */
    public function updateMessageByObj(array $message)
    {
        $parameters = ['message' => $message];

        return (bool) $this->apiClient->doCall('updateMessageByObj', $parameters);
    }

    /**
     * Clone a message.
     *
     * @param  string $id      ID of the message.
     * @param  string $newName Name of the newly created message.
     *
     * @return string ID of the newly created message.
     */
    public function cloneMessage($id, $newName)
    {
        $parameters = [
            'id' => (string) $id,
            'newName' => (string) $newName
        ];

        return (string) $this->apiClient->doCall('cloneMessage', $parameters);
    }

    /**
     * Get message.
     *
     * @param  string $id ID of the message.
     *
     * @return object The message object.
     */
    public function getMessage($id)
    {
        $parameters = ['id' => (string) $id];

        return $this->apiClient->doCall('getMessage', $parameters);
    }

    /**
     * Get last email-messages.
     *
     * @param  int   $limit Maximum number of messages to retrieve.
     *
     * @return array IDs of messages.
     */
    public function getLastEmailMessages($limit)
    {
        $parameters = ['limit' => (int) $limit];

        return (array) $this->apiClient->doCall('getLastEmailMessages', $parameters);
    }

    /**
     * Get last SMS-messages.
     *
     * @param  int   $limit Maximum number of messages to retrieve.
     *
     * @return array IDs of messages.
     */
    public function getLastSmsMessages($limit)
    {
        $parameters = ['limit' => (int) $limit];

        return (array) $this->apiClient->doCall('getLastSmsMessages', $parameters);
    }

    /**
     * Get email-messages by field.
     *
     * @param  string $field Field to search.
     * @param  mixed  $value Value to search.
     * @param  int    $limit Maximum number of messages to retrieve.
     *
     * @return array  IDs of messages matching the search.
     */
    public function getEmailMessagesByField($field, $value, $limit)
    {
        $parameters = [
            'field' => (string) $field,
            'value' => $value,
            'limit' => (int) $limit
        ];

        return (array) $this->apiClient->doCall('getEmailMessagesByField', $parameters);
    }

    /**
     * Get SMS-messages by field.
     *
     * @param  string $field Field to search.
     * @param  mixed  $value Value to search.
     * @param  int    $limit Maximum number of messages to retrieve.
     *
     * @return array  IDs of messages matching the search.
     */
    public function getSmsMessagesByField($field, $value, $limit)
    {
        $parameters = [
            'field' => (string) $field,
            'value' => $value,
            'limit' => (int) $limit
        ];

        return (array) $this->apiClient->doCall('getSmsMessagesByField', $parameters);
    }

    /**
     * Get messages by period.
     *
     * @param  int   $dateBegin Begin date of the period.
     * @param  int   $dateEnd   End date of the period.
     *
     * @return array IDs of messages matching the search.
     */
    public function getMessagesByPeriod($dateBegin, $dateEnd)
    {
        $parameters = [
            'dateBegin' => date('Y-m-d H:i:s', (int) $dateBegin),
            'dateEnd' => date('Y-m-d H:i:s', (int) $dateEnd)
        ];

        return (array) $this->apiClient->doCall('getMessagesByPeriod', $parameters);
    }

    /**
     * Get email-message preview.
     *
     * @param  string           $messageId ID of the message.
     * @param  string[optional] $part      Part of the message to preview (HTML or text).
     *
     * @return string           Preview of the message.
     *
     * @throws \Exception
     */
    public function getEmailMessagePreview($messageId, $part = 'HTML')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new \Exception('Invalid part ('. $part .'), allowed values are: '.implode(', ', $allowedParts).'.');
        }

        $parameters = [
            'id' => (string) $messageId,
            'part' => $part
        ];

        return (string) $this->apiClient->doCall('getEmailMessagePreview', $parameters);
    }

    /**
     * Get SMS-message preview.
     *
     * @param  string $messageId ID of the message.
     *
     * @return string Preview of the SMS-message.
     */
    public function getSmsMessagePreview($messageId)
    {
        $parameters = ['id' => (string) $messageId];

        return (string) $this->apiClient->doCall('getSmsMessagePreview', $parameters);
    }

    /**
     * Activate tracking for all links.
     *
     * @param  string $id ID of the message.
     *
     * @return string The ID of the last tracked URL
     */
    public function trackAllLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (string) $this->apiClient->doCall('trackAllLinks', $parameters);
    }

    /**
     * Deactivate link tracking for all links.
     *
     * @param  string $id ID of the message.
     *
     * @return bool   true if the untrack operation was successful.
     */
    public function untrackAllLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (bool) $this->apiClient->doCall('untrackAllLinks', $parameters);
    }

    /**
     * Tracks a link based on its position in an email.
     *
     * @param  string           $id       ID of the message.
     * @param  string           $position Position of the link to update in the message.
     * @param  string[optional] $part     HTML or text.
     *
     * @return string            The order number of the URL.
     *
     * @throws \Exception
     */
    public function trackLinkByPosition($id, $position, $part = 'HTML')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new \Exception('Invalid part ('. $part .'), allowed values are: '.implode(', ', $allowedParts).'.');
        }

        $parameters = [
            'id' => (string) $id,
            'position' => (string) $position,
            'part' => (string) $part
        ];

        return (string) $this->apiClient->doCall('trackLinkByPosition', $parameters);
    }

    /**
     * Get a list of all teh tracked links in an email.
     *
     * @param  string $id ID of the message.
     *
     * @return array  List of IDs of the tracked links.
     */
    public function getAllTrackedLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (array) $this->apiClient->doCall('getAllTrackedLinks', $parameters);
    }

    /**
     * Retrieves the unused tracked links for an email.
     *
     * @param  string $id ID of the message.
     *
     * @return array  List of IDs of the unused tracked links.
     */
    public function getAllUnusedTrackedLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (array) $this->apiClient->doCall('getAllUnusedTrackedLinks', $parameters);
    }

    /**
     * Retrieves all the trackable links in an email.
     *
     * @param  string $id ID of the message.
     *
     * @return array  List of IDs of the trackable links.
     */
    public function getAllTrackableLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (array) $this->apiClient->doCall('getAllTrackableLinks', $parameters);
    }

    /**
     * Sends a test email campaign to a group of recipients.
     *
     * @param  string   $id           The ID of the message to test.
     * @param  string   $groupId      The ID of the group to use for the test.
     * @param  string   $campaignName The name of the test campaign.
     * @param  string   $subject      The subject of the message to test.
     * @param  string   $part         The part of the message to send, allowed values are: HTML, TEXT, MULTIPART.
     *
     * @return bool            true if successfull, false otherwise.
     *
     * @throws \Exception
     */
    public function testEmailMessageByGroup($id, $groupId, $campaignName, $subject, $part = 'MULTIPART')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text', 'MUTLIPART'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new \Exception('Invalid part ('. $part .'), allowed values are: '.implode(', ', $allowedParts).'.');
        }

        $parameters = [
            'id' => (string) $id,
            'groupId' => (string) $groupId,
            'campaignName' => (string) $campaignName,
            'subject' => (string) $subject,
            'part' => (string) $part
        ];

        return (bool) $this->apiClient->doCall('testEmailMessageByGroup', $parameters);
    }

    /**
     * Sends a test email campaign to a member.
     *
     * @param  string   $id           The ID of the message to test.
     * @param  string   $memberId     The ID of the member to use for the test.
     * @param  string   $campaignName The name of the test campaign.
     * @param  string   $subject      The subject of the message to test.
     * @param  string   $part         The part of the message to send, allowed values are: HTML, TXT, MULTIPART.
     *
     * @return bool             true if successfull, false otherwise.
     *
     * @throws \Exception
     */
    public function testEmailMessageByMember($id, $memberId, $campaignName, $subject, $part = 'MULTIPART')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text', 'MUTLIPART'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new \Exception('Invalid part ('. $part .'), allowed values are: '.implode(', ', $allowedParts).'.');
        }

        $parameters = [
            'id' => (string) $id,
            'memberId' => (string) $memberId,
            'campaignName' => (string) $campaignName,
            'subject' => (string) $subject,
            'part' => (string) $part
        ];

        return (bool) $this->apiClient->doCall('testEmailMessageByMember', $parameters);
    }

    /**
     * Sends a test email campaign to a member.
     *
     * @param  string $id           The ID of the message to test.
     * @param  string $memberId     The ID of the member to use for the test.
     * @param  string $campaignName The name of the test campaign.
     *
     * @return bool   true if successfull, false otherwise.
     */
    public function testSmsMessage($id, $memberId, $campaignName)
    {
        $parameters = [
            'id' => (string) $id,
            'memberId' => (string) $memberId,
            'campaignName' => (string) $campaignName
        ];

        return (bool) $this->apiClient->doCall('testSmsMessage', $parameters);
    }

    /**
     * Retrieves the email address of the default sender.
     *
     * @return string The email address of the default sender.
     */
    public function getDefaultSender()
    {
        return (string) $this->apiClient->doCall('getDefaultSender');
    }

    /**
     * Get a list of validated alternate senders.
     *
     * @return array The list of email addresses.
     */
    public function getValidatedAltSenders()
    {
        return (array) $this->apiClient->doCall('getValidatedAltSenders');
    }

    /**
     * Get a list of not validated alternate senders.
     *
     * @return array The list of email addresses.
     */
    public function getNotValidatedSenders()
    {
        return (array) $this->apiClient->doCall('getNotValidatedSenders');
    }
}
