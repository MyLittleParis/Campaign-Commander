<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * CcmdURLService
 *
 * @author mylittleparis
 */
class CcmdURLService extends AbstractService
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
    }

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

        return (int) $this->soapClient->doCall('createStandardUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom
     * and replaces first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK]
     * (where ORDER is the standard link order number).
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

        return (int) $this->soapClient->doCall('createAndAddStandardUrl', $parameters);
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
    public function createUnsubscribeUrl(
        $messageId,
        $name,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createUnsubscribeUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom
     * and replaces the first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK]
     * (where ORDER is the unsubscribe link order number).
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
    public function createAndAddUnsubscribeUrl(
        $messageId,
        $name,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createAndAddUnsubscribeUrl', $parameters);
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

        return (int) $this->soapClient->doCall('createPersonalisedUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom
     * and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK]
     * (where ORDER is the personalized link order number).
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

        return (int) $this->soapClient->doCall('createAndAddPersonalisedUrl', $parameters);
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

        return (int) $this->soapClient->doCall('createUpdateUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom
     * and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK]
     * (where ORDER is the update link order number).
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
    public function createAndAddUpdateUrl(
        $messageId,
        $name,
        $parameters,
        $pageOk,
        $messageOk,
        $pageError,
        $messageError
    ) {
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'parameters' => $parameters,
            'pageOK' => (string) $pageOk,
            'messageOK' => (string) $messageOk,
            'pageError' => (string) $pageError,
            'messageError' => (string) $messageError
        ];

        return (int) $this->soapClient->doCall('createAndAddUpdateUrl', $parameters);
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
    public function createActionUrl(
        $messageId,
        $name,
        $action,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createActionUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom
     * and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK]
     * (where ORDER is the action link order number).
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
    public function createdAndAddActionUrl(
        $messageId,
        $name,
        $action,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createdAndAddActionUrl', $parameters);
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

        return (int) $this->soapClient->doCall('createMirrorUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom
     * and automatically replaces the first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK]
     * (where ORDER is the mirror link order number).
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

        return (int) $this->soapClient->doCall('createAndAddMirrorUrl', $parameters);
    }

    /**
     * Scans your message from top to bottom
     * and automatically replaces the first occurrence of &&& with [EMV SHARE lang=xx]
     * (where xx is the language identifier).
     *
     * @param  string           $messageId The ID of the message.
     * @param  bool             $linkType  The link type, true for link, false for button.
     * @param  string[optional] $buttonUrl The URL of the sharebutton.
     * @param  int[optional] $language  The language, possible values are:
     *         us, en, fr, de, nl, es, ru, sv, it, cn, tw, pt, br, da, ja, ko.
     *
     * @return bool
     *
     * @throws \Exception
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

        // Check if language is valid
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

            if ($language <= 0 || $language > 16) {
                throw new \Exception(
                    'Invalid language ('. $language .'), allowed values are: '.implode(', ', $allowedLanguage).'.'
                );
            }

            $parameters['language'] = (string) $language;
        }

        return (bool) $this->soapClient->doCall('addShareLink', $parameters);
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

        return (bool) $this->soapClient->doCall('updateUrlByField', $parameters);
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

        return (bool) $this->soapClient->doCall('deleteUrl', $parameters);
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

        return (array) $this->soapClient->doCall('getUrlByOrder', $parameters);
    }
}
