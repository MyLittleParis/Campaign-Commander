<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * CcmdDynamicContentBlockLinkService
 *
 * @author mylittleparis
 */
class CcmdDynamicContentBlockLinkService
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

        return (int) $this->soapClient->doCall('createStandardBannerLink', $parameters);
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

        return (int) $this->soapClient->doCall('createAndAddStandardBannerLink', $parameters);
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
    public function createUnsubscribeBannerLink(
        $id,
        $name,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createUnsubscribeBannerLink', $parameters);
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
    public function createAndAddUnsubscribeBannerLink(
        $id,
        $name,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createAndAddUnsubscribeBannerLink', $parameters);
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

        return (int) $this->soapClient->doCall('createPersonalisedBannerLink', $parameters);
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

        return (int) $this->soapClient->doCall('createAndAddPersonalisedBannerLink', $parameters);
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
    public function createUpdateBannerLink(
        $id,
        $name,
        $parameters,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createUpdateBannerLink', $parameters);
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
    public function createAndAddUpdateBannerLink(
        $id,
        $name,
        $parameters,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createAndAddUpdateBannerLink', $parameters);
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
    public function createActionBannerLink(
        $id,
        $name,
        $action,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createActionBannerLink', $parameters);
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
    public function createAndAddActionBannerLink(
        $id,
        $name,
        $action,
        $pageOk = null,
        $messageOk = null,
        $pageError = null,
        $messageError = null
    ) {
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

        return (int) $this->soapClient->doCall('createAndAddActionBannerLink', $parameters);
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

        return (int) $this->soapClient->doCall('createMirrorBannerLink', $parameters);
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

        return (int) $this->soapClient->doCall('createAndAddMirrorBannerLink', $parameters);
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

        return (bool) $this->soapClient->doCall('updateBannerLinkByField', $parameters);
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

        return (array) $this->soapClient->doCall('getBannerLinkByOrder', $parameters);
    }
}
