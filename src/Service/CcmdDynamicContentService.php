<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientInterface;

/**
 * CcmdDynamicContentService
 *
 * @author mylittleparis
 */
class CcmdDynamicContentService
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
     * Creates a banner.
     *
     * @param  string           $name        The name of the banner.
     * @param  string           $contentType The content type of the banner, possible values are: TEXT or HTML.
     * @param  string[optional] $content     The content of the banner.
     * @param  string[optional] $description The description.
     *
     * @return string           The ID of the Dynamic Content Block.
     *
     * @throws \Exception
     */
    public function createBanner($name, $contentType, $content, $description = null)
    {
        // List of valid status
        $allowedContentType = ['HTML','TEXT'];

        // Check if status is valid
        if (!in_array($contentType, $allowedContentType)) {
            throw new \Exception(
                'Invalid content type ('.$contentType.'), allowed values are: '.implode(', ', $allowedContentType).'.'
            );
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

        return (string) $this->apiClient->doCall('createBanner', $parameters);
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

        return (string) $this->apiClient->doCall('createBannerByObj', $parameters);
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

        return (bool) $this->apiClient->doCall('deleteBanner', $parameters);
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

        if (null !== $value) {
            $parameters['value'] = $value;
        }

        return (bool) $this->apiClient->doCall('updateBanner', $parameters);
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

        return (bool) $this->apiClient->doCall('updateBannerByObj', $parameters);
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

        return (string) $this->apiClient->doCall('cloneBanner', $parameters);
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

        return (string) $this->apiClient->doCall('getBannerPreview', $parameters);
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

        return $this->apiClient->doCall('getBanner', $parameters);
    }

    /**
     * Retrieves a list of banners that contain the given value in a field.
     *
     * @param  string          $field The field of the banner.
     * @param  mixed $value The value.
     * @param  int             $limit The size of the list (between 1 and 1000).
     *
     * @return array           The IDs of the Dynamic Content Block.
     *
     * @throws \Exception
     */
    public function getBannersByField($field, $value, $limit)
    {
        if ($limit <= 0 || $limit > 1000) {
            throw new \Exception('Invalid limit, the size of the list must be between 1 and 1000');
        }

        $parameters = [
            'field' => (string) $field,
            'value' => $value,
            'limit' => (int) $limit
        ];

        return (array) $this->apiClient->doCall('getBannersByField', $parameters);
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

        return (array) $this->apiClient->doCall('getBannersByPeriod', $parameters);
    }

    /**
     * Retrieves the list of the last banners.
     *
     * @param  int   $limit The size of the list (between 1 and 1000).
     *
     * @return array The IDs of the Dynamic Content Block.
     *
     * @throws \Exception
     */
    public function getLastBanners($limit)
    {
        if ($limit <= 0 || $limit > 1000) {
            throw new \Exception('Invalid limit, the size of the list must be between 1 and 1000');
        }

        $parameters = ['limit' => (int) $limit];

        return (array) $this->apiClient->doCall('getLastBanners', $parameters);
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

        return (int) $this->apiClient->doCall('trackAllBannerLinks', $parameters);
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

        return (int) $this->apiClient->doCall('untrackAllBannerLinks', $parameters);
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

        return (int) $this->apiClient->doCall('trackBannerLinkByPosition', $parameters);
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

        return (bool) $this->apiClient->doCall('untrackBannerLinkByOrder', $parameters);
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

        return (array) $this->apiClient->doCall('getAllBannerTrackedLinks', $parameters);
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

        return (array) $this->apiClient->doCall('getAllUnusedBannerTrackedLinks', $parameters);
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

        return (array) $this->apiClient->doCall('getAllBannerTrackableLinks', $parameters);
    }
}
