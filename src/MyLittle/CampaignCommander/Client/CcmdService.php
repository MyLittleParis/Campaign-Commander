<?php

namespace MyLittle\CampaignCommander\Client;

use MyLittle\CampaignCommander\Exception\CampaignCommanderException;

/**
 * Description of CcmdService
 *
 * @author mylittleparis
 */
class CcmdService extends AbstractClient
{
// Message methods
    /**
     * Constructor
     *
     * {@inheritDoc}
     */
    public function __construct($login, $password, $key, $wsdl = self::WSDL_URL_CCMD, $server = null)
    {
        parent::__construct($login, $password, $key, $wsdl, $server);
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
    public function createEmailMessage( $name,
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
                                        $unsublinkpage = null)
    {
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

        return (string) $this->doCall('createEmailMessage', $parameters);
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

        return $this->doCall('createEmailMessageByObj', $parameters);
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

        return (string) $this->doCall('createSMSMessage', $parameters);
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

        return $this->doCall('createSmsMessageByObj', $parameters);
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

        return (bool) $this->doCall('deleteMessage', $parameters);
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

        return (bool) $this->doCall('updateMessage', $parameters);
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

        return $this->doCall('updateMessageByObj', $parameters);
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

        return (string) $this->doCall('cloneMessage', $parameters);
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

        return $this->doCall('getMessage', $parameters);
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

        return (array) $this->doCall('getLastEmailMessages', $parameters);
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

        return (array) $this->doCall('getLastSmsMessages', $parameters);
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

        return (array) $this->doCall('getEmailMessagesByField', $parameters);
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

        return (array) $this->doCall('getSmsMessagesByField', $parameters);
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

        return (array) $this->doCall('getMessagesByPeriod', $parameters);
    }

    /**
     * Get email-message preview.
     *
     * @param  string           $messageId ID of the message.
     * @param  string[optional] $part      Part of the message to preview (HTML or text).
     *
     * @return string           Preview of the message.
     */
    public function getEmailMessagePreview($messageId, $part = 'HTML')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new CampaignCommanderException('Invalid part (' . $part . '), allowed values are: ' . implode(', ', $allowedParts) . '.');
        }

        $parameters = [
            'id' => (string) $messageId,
            'part' => $part
        ];

        return (string) $this->doCall('getEmailMessagePreview', $parameters);
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

        return (string) $this->doCall('getSmsMessagePreview', $parameters);
    }

    /**
     * Activate tracking for all links.
     *
     * @param  string $id ID of the message.
     *
     * @return array
     */
    public function trackAllLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return $this->doCall('trackAllLinks', $parameters);
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

        return $this->doCall('untrackAllLinks', $parameters);
    }

    /**
     * Tracks a link based on its position in an email.
     *
     * @param  string           $id       ID of the message.
     * @param  string           $position Position of the link to update in the message.
     * @param  string[optional] $part     HTML or text.
     *
     * @return array            The order number of the URL.
     */
    public function trackLinkByPosition($id, $position, $part = 'HTML')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new CampaignCommanderException('Invalid part (' . $part . '), allowed values are: ' . implode(', ', $allowedParts) . '.');
        }

        $parameters = [
            'id' => (string) $id,
            'position' => (string) $position,
            'part' => (string) $part
        ];

        return $this->doCall('trackLinkByPosition', $parameters);
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

        return (array) $this->doCall('getAllTrackedLinks', $parameters);
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

        return (array) $this->doCall('getAllUnusedTrackedLinks', $parameters);
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

        return (array) $this->doCall('getAllTrackableLinks', $parameters);
    }

    /**
     * Sends a test email campaign to a group of recipients.
     *
     * @param  string           $id           The ID of the message to test.
     * @param  string           $groupId      The ID of the group to use for the test.
     * @param  string           $campaignName The name of the test campaign.
     * @param  string           $subject      The subject of the message to test.
     * @param  string[optional] $part         The part of the message to send, allowed values are: HTML, TEXT, MULTIPART.
     *
     * @return bool            true if successfull, false otherwise.
     */
    public function testEmailMessageByGroup($id, $groupId, $campaignName, $subject, $part = 'MULTIPART')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text', 'MUTLIPART'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new CampaignCommanderException('Invalid part (' . $part . '), allowed values are: ' . implode(', ', $allowedParts) . '.');
        }

        $parameters = [
            'id' => (string) $id,
            'groupId' => (string) $groupId,
            'campaignName' => (string) $campaignName,
            'subject' => (string) $subject,
            'part' => (string) $part
        ];

        return (bool) $this->doCall('testEmailMessageByGroup', $parameters);
    }

    /**
     * Sends a test email campaign to a member.
     *
     * @param  string           $id           The ID of the message to test.
     * @param  string           $memberId     The ID of the member to use for the test.
     * @param  string           $campaignName The name of the test campaign.
     * @param  string           $subject      The subject of the message to test.
     * @param  string[optional] $part         The part of the message to send, allowed values are: HTML, TXT, MULTIPART.
     *
     * @return bool             true if successfull, false otherwise.
     */
    public function testEmailMessageByMember($id, $memberId, $campaignName, $subject, $part = 'MULTIPART')
    {
        // List of valid parts
        $allowedParts = ['HTML', 'text', 'MUTLIPART'];

        // Check if parts is valid
        if (!in_array($part, $allowedParts)) {
            throw new CampaignCommanderException('Invalid part (' . $part . '), allowed values are: ' . implode(', ', $allowedParts) . '.');
        }

        $parameters = [
            'id' => (string) $id,
            'memberId' => (string) $memberId,
            'campaignName' => (string) $campaignName,
            'subject' => (string) $subject,
            'part' => (string) $part
        ];

        return (bool) $this->doCall('testEmailMessageByMember', $parameters);
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

        return (bool) $this->doCall('testSmsMessage', $parameters);
    }

    /**
     * Retrieves the email address of the default sender.
     *
     * @return string The email address of the default sender.
     */
    public function getDefaultSender()
    {
        return (string) $this->doCall('getDefaultSender');
    }

    /**
     * Get a list of validated alternate senders.
     *
     * @return array The list of email addresses.
     */
    public function getValidatedAltSenders()
    {
        return (array) $this->doCall('getValidatedAltSenders');
    }

    /**
     * Get a list of not validated alternate senders.
     *
     * @return array The list of email addresses.
     */
    public function getNotValidatedSenders()
    {
        return (array) $this->doCall('getNotValidatedSenders');
    }

// Url methods
    /**
     * Creates a standard link for an email.
     *
     * @param  string $messageId ID of the message.
     * @param  string $name      Name of the URL.
     * @param  string $url       URL to add.
     *
     * @return integer          The order number of the URL.
     */
    public function createStandardUrl($messageId, $name, $url)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createStandardUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom and replaces first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the standard link order number).
     *
     * @param  string $messageId The ID for the message.
     * @param  string $name      The name of the URL.
     * @param  string $url       The url of the link.
     *
     * @return int    The order number of the url.
     */
    public function createAndAddStandardUrl($messageId, $name, $url)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createAndAddStandardUrl', $parameters);
    }

    /**
     * Creates an unsubscribe link for an email.
     *
     * @param  string           $messageId    ID of the message.
     * @param  string           $name         Name of the URL.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           The order number of the URL.
     */
    public function createUnsubscribeUrl($messageId,
                                         $name,
                                         $pageOk = null,
                                         $messageOk = null,
                                         $pageError = null,
                                         $messageError = null)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }
        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }
        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }
        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createUnsubscribeUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom and replaces the first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the unsubscribe link order number).
     *
     * @param  string           $messageId    ID of the message.
     * @param  string           $name         Name of the URL.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           The order number of the url.
     */
    public function createAndAddUnsubscribeUrl( $messageId,
                                                $name,
                                                $pageOk = null,
                                                $messageOk = null,
                                                $pageError = null,
                                                $messageError = null)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }
        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }
        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }
        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createAndAddUnsubscribeUrl', $parameters);
    }

    /**
     * Creates an personalised link for an email
     *
     * @param  string $messageId ID of the message.
     * @param  string $name      Name of the URL.
     * @param  string $url       URL to add.
     *
     * @return int The order number of the URL.
     */
    public function createPersonalisedUrl($messageId, $name, $url)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createPersonalisedUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the personalized link order number).
     *
     * @param  string $messageId ID of the message.
     * @param  string $name      Name of the URL.
     * @param  string $url       URL to add.
     *
     * @return int The order number of the URL.
     */
    public function createAndAddPersonalisedUrl($messageId, $name, $url)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createAndAddPersonalisedUrl', $parameters);
    }

    /**
     * Creates an update URL.
     *
     * @param  string $messageId    ID of the message.
     * @param  string $name         Name of the URL.
     * @param  mixed  $parameters   Update parameters to apply to the member table (for a particular member).
     * @param  string $pageOk       Url to call when unsubscribe was successful.
     * @param  string $messageOk    Message to display when unsubscribe was successful.
     * @param  string $pageError    Url to call when unsubscribe was unsuccessful.
     * @param  string $messageError Message to display when unsubscribe was unssuccessful.
     *
     * @return int The order number of the URL.
     */
    public function createUpdateUrl($messageId, $name, $parameters, $pageOk, $messageOk, $pageError, $messageError)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'parameters' => $parameters,
            'pageOK' => (string) $pageOk,
            'messageOK' => (string) $messageOk,
            'pageError' => (string) $pageError,
            'messageError' => (string) $messageError
        ];

        return (int) $this->doCall('createUpdateUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the update link order number).
     *
     * @param  string $messageId    ID of the message.
     * @param  string $name         Name of the URL.
     * @param  mixed  $parameters   Update parameters to apply to the member table (for a particular member).
     * @param  string $pageOk       Url to call when unsubscribe was successful.
     * @param  string $messageOk    Message to display when unsubscribe was successful.
     * @param  string $pageError    Url to call when unsubscribe was unsuccessful.
     * @param  string $messageError Message to display when unsubscribe was unssuccessful.
     *
     * @return int The order number of the URL.
     */
    public function createAndAddUpdateUrl($messageId, $name, $parameters, $pageOk, $messageOk, $pageError, $messageError)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'parameters' => $parameters,
            'pageOK' => (string) $pageOk,
            'messageOK' => (string) $messageOk,
            'pageError' => (string) $pageError,
            'messageError' => (string) $messageError
        ];

        return (int) $this->doCall('createAndAddUpdateUrl', $parameters);
    }

    /**
     * Creates an action link for an email.
     *
     * @param  string           $messageId    The ID of the message to which to add a URL.
     * @param  string           $name         The name of the URL.
     * @param  string           $action       The action to perform.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int          The order number of the URL.
     */
    public function createActionUrl($messageId,
                                    $name,
                                    $action,
                                    $pageOk = null,
                                    $messageOk = null,
                                    $pageError = null,
                                    $messageError = null)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'action' => (string) $action
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }
        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }
        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }
        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createActionUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the action link order number).
     *
     * @param  string           $messageId    The ID of the message to which to add a URL.
     * @param  string           $name         The name of the URL.
     * @param  string           $action       The action to perform.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int          The order number of the URL.
     */
    public function createdAndAddActionUrl( $messageId,
                                            $name,
                                            $action,
                                            $pageOk = null,
                                            $messageOk = null,
                                            $pageError = null,
                                            $messageError = null)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'action' => (string) $action
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }
        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }
        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }
        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createdAndAddActionUrl', $parameters);
    }

    /**
     * Creates a mirror URL for an email.
     *
     * @param  string $messageId ID of the message.
     * @param  string $name      Name of the URL.
     *
     * @return int          The order number of the url.
     */
    public function createMirrorUrl($messageId, $name)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name
        ];

        return (int) $this->doCall('createMirrorUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom and automatically replaces the first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the mirror link order number).
     *
     * @param  string $messageId ID of the message.
     * @param  string $name      Name of the URL.
     *
     * @return int          The order number of the url.
     */
    public function createAndAddMirrorUrl($messageId, $name)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name
        ];

        return (int) $this->doCall('createAndAddMirrorUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom and automatically replaces the first occurrence of &&& with [EMV SHARE lang=xx] (where xx is the language identifier).
     *
     * @param  string           $messageId The ID of the message.
     * @param  bool             $linkType  The link type, true for link, false for button.
     * @param  string[optional] $buttonUrl The URL of the sharebutton.
     * @param  int[optional] $language  The language, possible values are: us, en, fr, de, nl, es, ru, sv, it, cn, tw, pt, br, da, ja, ko.
     *
     * @return bool
     */
    public function addShareLink($messageId, $linkType, $buttonUrl = null, $language = 1)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'linkType' => (bool) $linkType
        ];

        if (null !== $buttonUrl) {
            $parameters['buttonUrl'] = (string) $buttonUrl;
        }

        // @todo check the validation of language
        if (null !== $language) {
            // List of valid parts
            $allowedLanguage = [
                1 => 'English (US)',
                2 => 'English (UK)',
                3 => 'French',
                4 => 'German',
                5 => 'Dutch',
                6 => 'Spanish',
                7 => 'Russian',
                8 => 'Swedish',
                9 => 'Italian',
                10 => 'Simplified Chinese',
                11 => 'Traditional Chinese',
                12 => 'Portuguese (Portugal)',
                13 => 'Portuguese (Brazil)',
                14 => 'Danish',
                15 => 'Japanese',
                16 => 'Korean'
            ];

            // Check if language is valid
            if (!in_array($language, $allowedLanguage)) {
                throw new CampaignCommanderException('Invalid language (' . $language . '), allowed values are: ' . implode(', ', $allowedLanguage) . '.');
            }

            $parameters['language'] = (string) $language;
        }

        return (bool) $this->doCall('addShareLink', $parameters);
    }

    /**
     * Update an URL by field.
     *
     * @param  string $messageId ID of the message.
     * @param  int    $order     Order of the URL.
     * @param  string $field     Field to update.
     * @param  mixed  $value     Value to set.
     *
     * @return bool   true if the update was successful.
     */
    public function updateUrlByField($messageId, $order, $field, $value)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'order' => (int) $order,
            'field' => (string) $field,
            'value' => $value
        ];

        return (bool) $this->doCall('updateUrlByField', $parameters);
    }

    /**
     * Delete an URL.
     *
     * @param  string $messageId ID of the message.
     * @param  int    $order     Order of the URL.
     *
     * @return bool   true if the delete was successful.
     */
    public function deleteUrl($messageId, $order)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'order' => (int) $order
        ];

        return (bool) $this->doCall('deleteUrl', $parameters);
    }

    /**
     * Get an URL by his order
     *
     * @param  string $messageId ID of the message.
     * @param  int    $order     Order of the URL.
     *
     * @return array  The URL parameters.
     */
    public function getUrlByOrder($messageId, $order)
    {
        $parameters = [
            'messageId' => (string) $messageId,
            'order' => (int) $order
        ];

        return (array) $this->doCall('getUrlByOrder', $parameters);
    }

// Segment methods
    /**
     * Creates a segment.
     *
     * @param  string           $name        The name of the segment.
     * @param  string           $sampleType  The portion of the segment uses, possible values are: ALL, PERCENT, FIX.
     * @param  float[optional]  $sampleRate  The percentage/number of members from the segment.
     * @param  string[optional] $description The description of the segment.
     *
     * @return string           The ID of the created segment.
     */
    public function segmentationCreateSegment($name, $sampleType, $sampleRate = null, $description = null)
    {
        // List of valid sample type
        $allowedSampleType = ['ALL', 'PERCENT', 'FIX'];

        // Check if sample type is valid
        if (!in_array($sampleType, $allowedSampleType)) {
            throw new CampaignCommanderException('Invalid sample type (' . $sampleType . '), allowed values are: ' . implode(', ', $allowedSampleType) . '.');
        }

        if ('ALL' !== $sampleType && null === $sampleRate) {
            throw new CampaignCommanderException("You have specified '$sampleType' for sample type, but you must give a $sampleType number of members from the segment.");
        }

        // @todo check if it work without id parameter (i.e. @remark)
        // @remark  don't ask me why. If I provide null or an empty string a get an Internal error.
        $parameters = [
            'apiSegmentation' => [
//                'id' => 0,
                'name' => (string) $name,
                'sampleType' => (string) $sampleType
            ]
        ];

        if (!empty($sampleRate)) {
            $parameters['apiSegmentation']['sampleRate'] = (float) $sampleRate;
        }

        if (null !== $description) {
            $parameters['apiSegmentation']['description'] = (string) $description;
        }

        return (string) $this->doCall('segmentationCreateSegment', $parameters);
    }

    /**
     * Delete a segment
     *
     * @param  string $id The ID of the segment.
     *
     * @return bool   true if successfull, false otherwise.
     */
    public function segmentationDeleteSegment($id)
    {
        $parameters = ['difflistId' => (string) $id];

        return (bool) $this->doCall('segmentationDeleteSegment', $parameters);
    }

    /**
     * Updates a segment.
     *
     * @param  string          $id         The ID of the segment.
     * @param  string          $name       The name of the segment.
     * @param  string          $sampleType The portion of the segment uses, possible values are: ALL, PERCENT, FIX.
     * @param  float[optional] $sampleRate The percentage/number of members from the segment.
     *
     * @return bool            true on success, false otherwise
     */
    public function segmentationUpdateSegment($id, $name = null, $sampleType, $sampleRate = null)
    {
        // List of valid sample type
        $allowedSampleType = ['ALL', 'PERCENT', 'FIX'];

        // Check if sample type is valid
        if (!in_array($sampleType, $allowedSampleType)) {
            throw new CampaignCommanderException('Invalid sample type (' . $sampleType . '), allowed values are: ' . implode(', ', $allowedSampleType) . '.');
        }

        if ('ALL' !== $sampleType && null === $sampleRate) {
            throw new CampaignCommanderException("You have specified '$sampleType' for sample type, but you must give a $sampleType number of members from the segment.");
        }

        $parameters = [
            'apiSegmentation' => [
                'id' => $id,
                'sampleType' => (string) $sampleType
            ]
        ];

        if (null !== $name) {
            $parameters['apiSegmentation']['name'] = (string) $name;
        }

        if (!empty($sampleRate)) {
            $parameters['apiSegmentation']['sampleRate'] = (float) $sampleRate;
        }

        return (bool) $this->doCall('segmentationUpdateSegment', $parameters);
    }

    /**
     * Adds alphanumeric demographic criteria to a segment.
     *
     * @param  array $stringDemographicCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddStringDemographicCriteriaByObj(array $stringDemographicCriteria)
    {
        $parameters = ['stringDemographicCriteria' => $stringDemographicCriteria];

        return (bool) $this->doCall('segmentationAddStringDemographicCriteriaByObj', $parameters);
    }

    /**
     * Adds numeric demographic criteria to a segment.
     *
     * @param  array $numericDemographicCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddNumericDemographicCriteriaByObj(array $numericDemographicCriteria)
    {
        $parameters = ['numericDemographicCriteria' => $numericDemographicCriteria];

        return (bool) $this->doCall('segmentationAddNumericDemographicCriteriaByObj', $parameters);
    }

    /**
     * Adds date demographic criteria to a segment.
     *
     * @param  array $dateDemographicCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddDateDemographicCriteriaByObj(array $dateDemographicCriteria)
    {
        $parameters = ['dateDemographicCriteria' => $dateDemographicCriteria];

        return (bool) $this->doCall('segmentationAddDateDemographicCriteriaByObj', $parameters);
    }

    /**
     * Adds campaign action criteria to a segment.
     *
     * @param  array $actionCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddCampaignActionCriteriaByObj(array $actionCriteria)
    {
        $parameters = ['actionCriteria' => $actionCriteria];

        return (bool) $this->doCall('segmentationAddCampaignActionCriteriaByObj', $parameters);
    }

    /**
     * Adds campaign tracked link criteria to a segment.
     *
     * @param  array $trackableLinkCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddCampaignTrackableLinkCriteriaByObj(array $trackableLinkCriteria)
    {
        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        return (bool) $this->doCall('segmentationAddCampaignTrackableLinkCriteriaByObj', $parameters);
    }

    /**
     * Adds reflex campaign action criteria to a segment.
     *
     * @param  array $actionCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddSerieActionCriteriaByObj(array $actionCriteria)
    {
        $parameters = ['actionCriteria' => $actionCriteria];

        return (bool) $this->doCall('segmentationAddSerieActionCriteriaByObj', $parameters);
    }

    /**
     * Adds reflex campaign tracked link criteria to a segment.
     *
     * @param  array $trackableLinkCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddSerieTrackableLinkCriteriaByObj(array $trackableLinkCriteria)
    {
        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        return (bool) $this->doCall('segmentationAddSerieTrackableLinkCriteriaByObj', $parameters);
    }

    /**
     * Adds social criteria to a segment.
     *
     * @param  array $socialNetworkCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddSocialNetworkCriteriaByObj(array $socialNetworkCriteria)
    {
        $parameters = ['socialNetworkCriteria' => $socialNetworkCriteria];

        return (bool) $this->doCall('segmentationAddSocialNetworkCriteriaByObj', $parameters);
    }

    /**
     * Adds quick segment criteria to segment.
     *
     * @param  array $recencyCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddRecencyCriteriaByObj(array $recencyCriteria)
    {
        $parameters = ['recencyCriteria' => $recencyCriteria];

        return (bool) $this->doCall('segmentationAddRecencyCriteriaByObj', $parameters);
    }

    /**
     * Adds DataMart criteria to a segment.
     *
     * @param  array $dataMartCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationAddDataMartCriteriaByObj(array $dataMartCriteria)
    {
        $parameters = ['dataMartCriteria' => $dataMartCriteria];

        return (bool) $this->doCall('segmentationAddDataMartCriteriaByObj', $parameters);
    }

    /**
     * Retrieves a segment.
     *
     * @param  string $id The ID of the segment.
     *
     * @return An ApiSegmentation object
     */
    public function segmentationGetSegmentById($id)
    {
        $parameters = ['difflistId' => (string) $id];

        return $this->doCall('segmentationGetSegmentById', $parameters);
    }

    /**
     * Retrieves a list of segments.
     *
     * @param  int   $page         The current page.
     * @param  int   $itemsPerPage The number of items per page.
     *
     * @return array A list of ApiSegmentation objects.
     */
    public function segmentationGetSegmentList($page, $itemsPerPage)
    {
        $parameters = [
            'page' => (int) $page,
            'nbItemsPerPage' => (int) $itemsPerPage
        ];

        return (array) $this->doCall('segmentationGetSegmentList', $parameters);
    }

    /**
     * Get the criteria used in a segment.
     *
     * @param  string $id The ID of the segment.
     *
     * @return array  An ApiSegmentation object
     */
    public function segmentationGetSegmentCriterias($id)
    {
        $parameters = ['difflistId' => (string) $id];

        return (array) $this->doCall('segmentationGetSegmentCriterias', $parameters);
    }

    /**
     * Retrieves a list of DataMart segments
     *
     * @param  int   $page         The current page.
     * @param  int   $itemsPerPage The number of items per page.
     *
     * @return array
     */
    public function segmentationGetPersoFragList($page, $itemsPerPage)
    {
        $parameters = [
            'pageNumber' => (int) $page,
            'nbItemPerPage' => (int) $itemsPerPage
        ];

        return (array) $this->doCall('segmentationGetPersoFragList', $parameters);
    }

    /**
     * Delete a criteria cell.
     *
     * @param  string $id            The ID of the segment.
     * @param  int    $orderCriteria The ofder or the criteria.
     *
     * @return bool   true on success, false otherwise.
     */
    public function segmentationDeleteCriteria($id, $orderCriteria)
    {
        $parameters = [
            'difflistId' => (string) $id,
            'orderCriteria' => (int) $orderCriteria
        ];

        return (bool) $this->doCall('segmentationDeleteCriteria', $parameters);
    }

    /**
     * Updates alphanumeric demographic criteria to a segment.
     *
     * @param  array $stringDemographicCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateStringDemographicCriteriaByObj(array $stringDemographicCriteria)
    {
        $parameters = ['stringDemographicCriteria' => $stringDemographicCriteria];

        return (bool) $this->doCall('segmentationUpdateStringDemographicCriteriaByObj', $parameters);
    }

    /**
     * Updates numeric demographic criteria to a segment.
     *
     * @param  array $numericDemographicCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateNumericDemographicCriteriaByObj(array $numericDemographicCriteria)
    {
        $parameters = ['numericDemographicCriteria' => $numericDemographicCriteria];

        return (bool) $this->doCall('segmentationUpdateNumericDemographicCriteriaByObj', $parameters);
    }

    /**
     * Updates date demographic criteria to a segment.
     *
     * @param  array $dateDemographicCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateDateDemographicCriteriaByObj(array $dateDemographicCriteria)
    {
        $parameters = ['dateDemographicCriteria' => $dateDemographicCriteria];

        return (bool) $this->doCall('segmentationUpdateDateDemographicCriteriaByObj', $parameters);
    }

    /**
     * Updates campaign action criteria to a segment.
     *
     * @param  array $actionCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateCampaignActionCriteriaByObj(array $actionCriteria)
    {
        $parameters = ['actionCriteria' => $actionCriteria];

        return (bool) $this->doCall('segmentationUpdateCampaignActionCriteriaByObj', $parameters);
    }

    /**
     * Updates campaign tracked link criteria to a segment.
     *
     * @param  array $trackableLinkCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateCampaignTrackableLinkCriteriaByObj(array $trackableLinkCriteria)
    {
        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        return (bool) $this->doCall('segmentationUpdateCampaignTrackableLinkCriteriaByObj', $parameters);
    }

    /**
     * Updates reflex campaign action criteria to a segment.
     *
     * @param  array $actionCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateSerieActionCriteriaByObj(array $actionCriteria)
    {
        $parameters = ['actionCriteria' => $actionCriteria];

        return (bool) $this->doCall('segmentationUpdateSerieActionCriteriaByObj', $parameters);
    }

    /**
     * Updates reflex campaign tracked link criteria to a segment.
     *
     * @param  array $trackableLinkCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateSerieTrackableLinkCriteriaByObj(array $trackableLinkCriteria)
    {
        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        return (bool) $this->doCall('segmentationUpdateSerieTrackableLinkCriteriaByObj', $parameters);
    }

    /**
     * Updates social criteria to a segment.
     *
     * @param  array $socialNetworkCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateSocialNetworkCriteriaByObj(array $socialNetworkCriteria)
    {
        $parameters = ['socialNetworkCriteria' => $socialNetworkCriteria];

        return (bool) $this->doCall('segmentationUpdateSocialNetworkCriteriaByObj', $parameters);
    }

    /**
     * Updates quick segment criteria to segment.
     *
     * @param  array $recencyCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateRecencyCriteriaByObj(array $recencyCriteria)
    {
        $parameters = ['recencyCriteria' => $recencyCriteria];

        return (bool) $this->doCall('segmentationUpdateRecencyCriteriaByObj', $parameters);
    }

    /**
     * Updates DataMart criteria to a segment.
     *
     * @param  array $dataMartCriteria The criteria object.
     *
     * @return bool  true on success, false otherwise.
     */
    public function segmentationUpdateDataMartCriteriaByObj(array $dataMartCriteria)
    {
        $parameters = ['dataMartCriteria' => $dataMartCriteria];

        return (bool) $this->doCall('segmentationUpdateDataMartCriteriaByObj', $parameters);
    }

    /**
     * Counts the total number of members in a segment (including duplicated members).
     *
     * @param  string $id The ID of the segment.
     *
     * @return int    The number of members.
     */
    public function segmentationCount($id)
    {
        $parameters = ['id' => (string) $id];

        return (int) $this->doCall('segmentationCount', $parameters);
    }

    /**
     * Counts the total number of distinct members in a segment (duplicate members are removed).
     *
     * @param  string $id The ID of the segment.
     *
     * @return int    The number of members.
     */
    public function segmentationDistinctCount($id)
    {
        $parameters = ['id' => (string) $id];

        return (int) $this->doCall('segmentationDistinctCount', $parameters);
    }

// Campaign methods
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
     * @param  bool[optional]   $emaildedupfig     Deduplicate the mailing list?
     *
     * @return string           The ID of the campaign.
     */
    public function createCampaign( $name,
                                    $sendDate,
                                    $messageId,
                                    $mailingListId,
                                    $description = null,
                                    $notifProgress = false,
                                    $postClickTracking = false,
                                    $emaildedupfig = false)
    {
        $parameters = [
            'name' => (string) $name,
            'sendDate' => date('Y-m-d H:i:s', (int) $sendDate),
            'messageId' => (string) $messageId,
            'mailingListId' => (string) $mailingListId,
            'notifProgress' => (bool) $notifProgress,
            'postClickTracking' => (bool) $postClickTracking,
            'emaildedupflg' => (bool) $emaildedupfig
        ];

        if (null !== $description) {
            $parameters['desc'] = (string) $description;
        }

        return (string) $this->doCall('createCampaign', $parameters);
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
     * @param  bool[optional]   $emaildedupfig     Deduplicate the mailing list?
     *
     * @return string           The ID of the campaign.
     */
    public function createCampaignWithAnalytics($name,
                                                $sendDate,
                                                $messageId,
                                                $mailingListId,
                                                $description = null,
                                                $notifProgress = false,
                                                $postClickTracking = false,
                                                $emaildedupfig = false)
    {
        $parameters = [
            'name' => (string) $name,
            'sendDate' => date('Y-m-d H:i:s', (int) $sendDate),
            'messageId' => (string) $messageId,
            'mailingListId' => (string) $mailingListId,
            'notifProgress' => (bool) $notifProgress,
            'postClickTracking' => (bool) $postClickTracking,
            'emaildedupflg' => (bool) $emaildedupfig
        ];

        if (null !== $description) {
            $parameters['desc'] = (string) $description;
        }

        return (string) $this->doCall('createCampaignWithAnalytics', $parameters);
    }

    /**
     * Create a campaign.
     *
     * @param  array  $campaign The campaign object.
     *
     * @return string The ID of the campaign.
     */
    public function createCampaignByObj(array $campaign)
    {
        $parameters = ['campaign' => $campaign];

        return (string) $this->doCall('createCampaignByObj', $parameters);
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

        return (bool) $this->doCall('deleteCampaign', $parameters);
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

        return (bool) $this->doCall('updateCampaign', $parameters);
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

        return (bool) $this->doCall('updateCampaignByObj', $parameters);
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

        return (bool) $this->doCall('postCampaign', $parameters);
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

        return (bool) $this->doCall('unpostCampaign', $parameters);
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

        return $this->doCall('getCampaign', $parameters);
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

        return (array) $this->doCall('getCampaignsByField', $parameters);
    }

    /**
     * Retrieves a list of campaign having a specified status
     *
     * @param  string $status Status to match, possible values: EDITABLE, QUEUED, RUNNING, PAUSES, COMPLETED, FAILED, KILLED.
     *
     * @return array  The list of campaign IDs matching the status.
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
            throw new CampaignCommanderException('Invalid status (' . $status . '), allowed values are: ' . implode(', ', $allowedStatus) . '.');
        }

        $parameters = ['status' => (string) $status];

        return (array) $this->doCall('getCampaignsByStatus', $parameters);
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

        return (array) $this->doCall('getCampaignsByPeriod', $parameters);
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

        return (string) $this->doCall('getCampaignStatus', $parameters);
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

        return (array) $this->doCall('getLastCampaigns', $parameters);
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

        return (bool) $this->doCall('testCampaignByGroup', $parameters);
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

        return (bool) $this->doCall('testCampaignByMember', $parameters);
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

        return (bool) $this->doCall('pauseCampaign', $parameters);
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

        return (bool) $this->doCall('unpauseCampaign', $parameters);
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

        return (array) $this->doCall('getCampaignSnapshotReport', $parameters);
    }

// Dynamic Content methods
    /**
     * Creates a banner.
     *
     * @param  string           $name        The name of the banner.
     * @param  string           $contentType The content type of the banner, possible values are: TEXT or HTML.
     * @param  string[optional] $content     The content of the banner.
     * @param  string[optional] $description The description.
     *
     * @return string           The ID of the Dynamic Content Block.
     */
    public function createBanner($name, $contentType, $content, $description = null)
    {
        // List of valid status
        $allowedContentType = ['HTML','TEXT'];

        // Check if status is valid
        if (!in_array($contentType, $allowedContentType)) {
            throw new CampaignCommanderException('Invalid content type (' . $contentType . '), allowed values are: ' . implode(', ', $allowedContentType) . '.');
        }

        $parameters = [
            'banner' => [
                'name' => (string) $name,
                'contentType' => (string) $contentType,
                'content' => '<!CDATA[' . $content . ']]>'
            ]
        ];

        if (null !== $description) {
            $parameters['banner']['description'] = (string) $description;
        }

        return (string) $this->doCall('createBanner', $parameters);
    }

    /**
     * Creates a banner.
     * @remark  you have to specify an id-element width value 0.
     *
     * @param  array  $banner The banner.
     *
     * @return string The ID of the Dynamic Content Block.
     */
    public function createBannerByObj(array $banner)
    {
        $parameters = ['banner' => $banner];

        return (string) $this->doCall('createBannerByObj', $parameters);
    }

    /**
     * Deletes a banner
     *
     * @param  string $id The ID of the banner.
     *
     * @return bool   true on success, false otherwise.
     */
    public function deleteBanner($id)
    {
        $parameters = ['id' => (string) $id];

        return (bool) $this->doCall('deleteBanner', $parameters);
    }

    /**
     * Updates a banner by field and value.
     *
     * @param  string          $id    The ID of the banner.
     * @param  string          $field The field.
     * @param  mixed[optional] $value The new value.
     *
     * @return bool            true on success, false otherwise.
     */
    public function updateBanner($id, $field, $value = null)
    {
        $parameters = [
            'id' => (string) $id,
            'field' => (string) $field
        ];

        if(null !== $value) {
            $parameters['value'] = $value;
        }

        return (bool) $this->doCall('updateBanner', $parameters);
    }

    /**
     * Updates a banner.
     *
     * @param  array $banner The banner.
     *
     * @return bool  true on success, false otherwise.
     */
    public function updateBannerByObj(array $banner)
    {
        $parameters = ['banner' => $banner];

        return (bool) $this->doCall('updateBannerByObj', $parameters);
    }

    /**
     * Clones a banner.
     *
     * @param  string $id   The ID of the banner.
     * @param  string $name The new name of the banner.
     *
     * @return string The ID of the new the Dynamic Content Block.
     */
    public function cloneBanner($id, $name)
    {
        $parameters = [
            'id' => (string) $id,
            'newName' => (string) $name
        ];

        return (string) $this->doCall('cloneBanner', $parameters);
    }

    /**
     * Displays a preview of a banner.
     *
     * @param  string $id The ID of the Dynamic Content Block.
     *
     * @return string The formatted preview of a Dynamic Content Block.
     */
    public function getBannerPreview($id)
    {
        $parameters = ['id' => (string) $id];

        return (string) $this->doCall('getBannerPreview', $parameters);
    }

    /**
     * Retrieves a banner.
     *
     * @param  string $id The ID of the Dynamic Content Block.
     *
     * @return APIBanner The Dynamic Content Block.
     */
    public function getBanner($id)
    {
        $parameters = ['id' => (string) $id];

        return $this->doCall('getBanner', $parameters);
    }

    /**
     * Retrieves a list of banners that contain the given value in a field.
     *
     * @param  string          $field The field of the banner.
     * @param  mixed $value The value.
     * @param  int             $limit The size of the list (between 1 and 1000).
     *
     * @return array           The IDs of the Dynamic Content Block.
     */
    public function getBannersByField($field, $value, $limit)
    {
        if ($limit <= 0 || $limit > 1000) {
            throw new CampaignCommanderException('Invalid limit, the size of the list must be between 1 and 1000');
        }

        $parameters = [
            'field' => (string) $field,
            'value' => $value,
            'limit' => (int) $limit
        ];

        return (array) $this->doCall('getBannersByField', $parameters);
    }

    /**
     * Retrieves a list of banners from a given period.
     *
     * @param  int   $dateStart The start date of the period.
     * @param  int   $dateEnd   The end date of the period.
     *
     * @return array The IDs of the Dynamic Content Block.
     */
    public function getBannersByPeriod($dateStart, $dateEnd)
    {
        $parameters = [
            'dateBegin' => date('Y-m-d H:i:s', (int) $dateStart),
            'dateEnd' => date('Y-m-d H:i:s', (int) $dateEnd)
        ];

        return (array) $this->doCall('getBannersByPeriod', $parameters);
    }

    /**
     * Retrieves the list of the last banners.
     *
     * @param  int   $limit The size of the list (between 1 and 1000).
     *
     * @return array The IDs of the Dynamic Content Block.
     */
    public function getLastBanners($limit)
    {
        if ($limit <= 0 || $limit > 1000) {
            throw new CampaignCommanderException('Invalid limit, the size of the list must be between 1 and 1000');
        }

        $parameters = ['limit' => (int) $limit];

        return (array) $this->doCall('getLastBanners', $parameters);
    }

    /**
     * Activates tracking for all untracked banner links and saves the banner.
     *
     * @param  string $id The ID of the banner.
     *
     * @return int    The last tracked link's order number.
     */
    public function trackAllBannerLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (int) $this->doCall('trackAllBannerLinks', $parameters);
    }

    /**
     * untracks all the banner links.
     *
     * @param  string $id The ID of the banner.
     *
     * @return int    The last tracked link's order number.
     */
    public function untrackAllBannerLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (int) $this->doCall('untrackAllBannerLinks', $parameters);
    }

    /**
     * Tracks the banner link through its position
     *
     * @param  string $id       The ID of the banner.
     * @param  int    $position The position of the link in the banner.
     *
     * @return int    The order number of the url.
     */
    public function trackBannerLinkByPosition($id, $position)
    {
        $parameters = [
            'id' => (string) $id,
            'position' => (int) $position
        ];

        return (int) $this->doCall('trackBannerLinkByPosition', $parameters);
    }

    /**
     * Untracks a link in the banner by its order.
     *
     * @param  string $id    The ID od the banner.
     * @param  int    $order The order number of the url.
     *
     * @return bool   true on success, false otherwise.
     */
    public function untrackBannerLinkByOrder($id, $order)
    {
        $parameters = [
            'id' => (string) $id,
            'order' => (int) $order
        ];

        return (bool) $this->doCall('untrackBannerLinkByOrder', $parameters);
    }

    /**
     * Retrieves a list of all the tracked links in a banner.
     *
     * @param  string $id The ID of the banner.
     *
     * @return array  List of the tracked links.
     */
    public function getAllBannerTrackedLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (array) $this->doCall('getAllBannerTrackedLinks', $parameters);
    }

    /**
     * Retrieves a list of all the unused tracked links in a banner.
     *
     * @param  string $id The ID of the banner.
     *
     * @return array  List of the unused tracked links.
     */
    public function getAllUnusedBannerTrackedLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (array) $this->doCall('getAllUnusedBannerTrackedLinks', $parameters);
    }

    /**
     * Retrieves a list of all the trackable links in a banner.
     *
     * @param  string $id The ID of the banner.
     *
     * @return array  List of the trackable links.
     */
    public function getAllBannerTrackableLinks($id)
    {
        $parameters = ['id' => (string) $id];

        return (array) $this->doCall('getAllBannerTrackableLinks', $parameters);
    }

// Dynamic Content Block Link methods
    /**
     * Creates a standard link for the banner.
     *
     * @param  string $id   The ID of the banner.
     * @param  string $name The name of the banner.
     * @param  string $url  The url of the link.
     *
     * @return int    The order number of the url.
     */
    public function createStandardBannerLink($id, $name, $url)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createStandardBannerLink', $parameters);
    }

    /**
     * Creates and add standard link to the banner.
     *
     * @param  string $id   The ID of the banner.
     * @param  string $name The name of the banner.
     * @param  string $url  The url of the link.
     *
     * @return int    The order number of the url.
     */
    public function createAndAddStandardBannerLink($id, $name, $url)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createAndAddStandardBannerLink', $parameters);
    }

    /**
     * Creates an unsubscribe link for the banner.
     *
     * @param  string           $id           ID of the banner.
     * @param  string           $name         Name of the URL.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           Order number of the URL.
     */
    public function createUnsubscribeBannerLink($id,
                                                $name,
                                                $pageOk = null,
                                                $messageOk = null,
                                                $pageError = null,
                                                $messageError = null)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createUnsubscribeBannerLink', $parameters);
    }

    /**
     * Creates and adds an unsubscribe link for the banner.
     *
     * @param  string           $id           ID of the banner.
     * @param  string           $name         Name of the URL.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           Order number of the URL.
     */
    public function createAndAddUnsubscribeBannerLink($id,
                                                      $name,
                                                      $pageOk = null,
                                                      $messageOk = null,
                                                      $pageError = null,
                                                      $messageError = null)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createAndAddUnsubscribeBannerLink', $parameters);
    }

    /**
     * Creates a personalized link to the banner.
     *
     * @param  string $id   The ID of the banner.
     * @param  string $name The name of the banner.
     * @param  string $url  The url of the link.
     *
     * @return int    The order number of the url.
     */
    public function createPersonalisedBannerLink($id, $name, $url)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createPersonalisedBannerLink', $parameters);
    }

    /**
     * Creates and adds personalized link to the banner.
     *
     * @param  string $id   The ID of the banner.
     * @param  string $name The name of the banner.
     * @param  string $url  The url of the link.
     *
     * @return int    The order number of the url.
     */
    public function createAndAddPersonalisedBannerLink($id, $name, $url)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        return (int) $this->doCall('createAndAddPersonalisedBannerLink', $parameters);
    }

    /**
     * Creates an update link for the banner.
     *
     * @param  string           $id           ID of the banner.
     * @param  string           $name         Name of the URL.
     * @param  mixed            $parameters   The updateparameters to apply to the member.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           Order number of the URL.
     */
    public function createUpdateBannerLink( $id,
                                            $name,
                                            $parameters,
                                            $pageOk = null,
                                            $messageOk = null,
                                            $pageError = null,
                                            $messageError = null)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'parameters' => $parameters
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createUpdateBannerLink', $parameters);
    }

    /**
     * Creates and adds an update link for the banner.
     *
     * @param  string           $id           ID of the banner.
     * @param  string           $name         Name of the URL.
     * @param  mixed            $parameters   The updateparameters to apply to the member.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           Order number of the URL.
     */
    public function createAndAddUpdateBannerLink($id,
                                                 $name,
                                                 $parameters,
                                                 $pageOk = null,
                                                 $messageOk = null,
                                                 $pageError = null,
                                                 $messageError = null)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'parameters' => $parameters
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createAndAddUpdateBannerLink', $parameters);
    }

    /**
     * Creates and adds an action link for the banner.
     *
     * @param  string           $id           ID of the banner.
     * @param  string           $name         Name of the URL.
     * @param  string           $action       The action to perform.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           Order number of the URL.
     */
    public function createActionBannerLink($id,
                                           $name,
                                           $action,
                                           $pageOk = null,
                                           $messageOk = null,
                                           $pageError = null,
                                           $messageError = null)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'action' => $action
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createActionBannerLink', $parameters);
    }

    /**
     * Creates and adds an action link for the banner.
     *
     * @param  string           $id           ID of the banner.
     * @param  string           $name         Name of the URL.
     * @param  string           $action       The action to perform.
     * @param  string[optional] $pageOk       URL to call when unsubscribe was successful.
     * @param  string[optional] $messageOk    Message to display when unsubscribe was successful.
     * @param  string[optional] $pageError    URL to call when unsubscribe was unsuccessful.
     * @param  string[optional] $messageError Message to display when unsubscribe was unsuccessful.
     *
     * @return int           Order number of the URL.
     */
    public function createAndAddActionBannerLink($id,
                                                 $name,
                                                 $action,
                                                 $pageOk = null,
                                                 $messageOk = null,
                                                 $pageError = null,
                                                 $messageError = null)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'action' => $action
        ];

        if (null !== $pageOk) {
            $parameters['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parameters['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parameters['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parameters['messageError'] = (string) $messageError;
        }

        return (int) $this->doCall('createAndAddActionBannerLink', $parameters);
    }

    /**
     * Creates a mirror link in the banner.
     *
     * @param  string $id   The id of the banner.
     * @param  string $name The name of the link.
     *
     * @return int    The order number of the url.
     */
    public function createMirrorBannerLink($id, $name)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name
        ];

        return (int) $this->doCall('createMirrorBannerLink', $parameters);
    }

    /**
     * Creates and adds a mirror link in the banner.
     *
     * @param  string $id   The id of the banner.
     * @param  string $name The name of the link.
     *
     * @return int    The order number of the url.
     */
    public function createAndAddMirrorBannerLink($id, $name)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name
        ];

        return (int) $this->doCall('createAndAddMirrorBannerLink', $parameters);
    }

    /**
     * Updates a banner link by field.
     *
     * @param  string          $id    The ID of the banner.
     * @param  int             $order The ordernumber of the url.
     * @param  string          $field The field.
     * @param  mixed[optional] $value The new value.
     *
     * @return bool            true on success, false otherwise.
     */
    public function updateBannerLinkByField($id, $order, $field, $value = null)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'order' => (string) $order,
            'field' => (string) $field
        ];

        if (null !== $value) {
            $parameters['value'] = $value;
        }

        return (bool) $this->doCall('updateBannerLinkByField', $parameters);
    }

    /**
     * Retrieves a banner link by its order number.
     *
     * @param  string $id    The ID of the banner.
     * @param  int    $order The order number.
     *
     * @return array         The Dynamic Content Block link
     */
    public function getBannerLinkByOrder($id, $order)
    {
        $parameters = [
            'bannerId' => (string) $id,
            'order' => (string) $order
        ];

        return (array) $this->doCall('getBannerLinkByOrder', $parameters);
    }

// Test Group methods
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

        return (string) $this->doCall('createTestGroup', $parameters);
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

        return (string) $this->doCall('createTestGroupByObj', $parameters);
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

        return (bool) $this->doCall('addTestMember', $parameters);
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

        return (bool) $this->doCall('removeTestMember', $parameters);
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

        return (bool) $this->doCall('deleteTestGroup', $parameters);
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

        return (bool) $this->doCall('updateTestGroupByObj', $parameters);
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

        return (array) $this->doCall('getTestGroup', $parameters);
    }

    /**
     * Retrieves a list of test groups.
     *
     * @return array The list of groups IDs.
     */
    public function getClientTestGroups()
    {
        return (array) $this->doCall('getClientTestGroups');
    }
}
