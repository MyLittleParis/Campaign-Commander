<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\SoapClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * Description of CcmdSegmentService
 *
 * @author mylittleparis
 */
class CcmdSegmentService
{
    /**
     * @var SoapClient
     */
    private $soapClient;

    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\Model\SoapClientFactoryInterface $soapClientFactory
     */
    public function __construct(SoapClientFactoryInterface $soapClientFactory)
    {
        $this->soapClient = $soapClientFactory->createClient(ClientInterface::WSDL_URL_CCMD);
    }

    /**
     * Creates a segment.
     *
     * @param  string           $name        The name of the segment.
     * @param  string           $sampleType  The portion of the segment uses, possible values are: ALL, PERCENT, FIX.
     * @param  float[optional]  $sampleRate  The percentage/number of members from the segment.
     * @param  string[optional] $description The description of the segment.
     *
     * @return string           The ID of the created segment.
     *
     * @throws \Exception
     */
    public function segmentationCreateSegment($name, $sampleType, $sampleRate = null, $description = null)
    {
        // List of valid sample type
        $allowedSampleType = ['ALL', 'PERCENT', 'FIX'];

        // Check if sample type is valid
        if (!in_array($sampleType, $allowedSampleType)) {
            throw new \Exception(
                'Invalid sample type ('. $sampleType .'), allowed values are: '.implode(', ', $allowedSampleType).'.'
            );
        }

        if ('ALL' !== $sampleType && null === $sampleRate) {
            throw new \Exception(
                "You have specified '$sampleType' for sample type, but you must give a $sampleType number of members from the segment."
            );
        }

        $parameters = [
            'apiSegmentation' => [
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

        return (string) $this->soapClient->doCall('segmentationCreateSegment', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationDeleteSegment', $parameters);
    }

    /**
     * Updates a segment.
     *
     * @param  string          $id         The ID of the segment.
     * @param  string          $sampleType The portion of the segment uses, possible values are: ALL, PERCENT, FIX.
     * @param  string          $name       The name of the segment.
     * @param  float[optional] $sampleRate The percentage/number of members from the segment.
     *
     * @return bool            true on success, false otherwise
     *
     * @throws \Exception
     */
    public function segmentationUpdateSegment($id, $sampleType, $name = null, $sampleRate = null)
    {
        // List of valid sample type
        $allowedSampleType = ['ALL', 'PERCENT', 'FIX'];

        // Check if sample type is valid
        if (!in_array($sampleType, $allowedSampleType)) {
            throw new \Exception(
                'Invalid sample type ('. $sampleType .'), allowed values are: '.implode(', ', $allowedSampleType).'.'
            );
        }

        if ('ALL' !== $sampleType && null === $sampleRate) {
            throw new \Exception(
                "You have specified '$sampleType' for sample type, but you must give a $sampleType number of members from the segment."
            );
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

        return (bool) $this->soapClient->doCall('segmentationUpdateSegment', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddStringDemographicCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddNumericDemographicCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddDateDemographicCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddCampaignActionCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddCampaignTrackableLinkCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddSerieActionCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddSerieTrackableLinkCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddSocialNetworkCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddRecencyCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationAddDataMartCriteriaByObj', $parameters);
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

        return $this->soapClient->doCall('segmentationGetSegmentById', $parameters);
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

        return (array) $this->soapClient->doCall('segmentationGetSegmentList', $parameters);
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

        return (array) $this->soapClient->doCall('segmentationGetSegmentCriterias', $parameters);
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

        return (array) $this->soapClient->doCall('segmentationGetPersoFragList', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationDeleteCriteria', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateStringDemographicCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateNumericDemographicCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateDateDemographicCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateCampaignActionCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateCampaignTrackableLinkCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateSerieActionCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateSerieTrackableLinkCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateSocialNetworkCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateRecencyCriteriaByObj', $parameters);
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

        return (bool) $this->soapClient->doCall('segmentationUpdateDataMartCriteriaByObj', $parameters);
    }

    /**
     * Counts the total number of members in a segment (including duplicated members).
     *
     * @param  string $id The ID of the segment.
     *
     * @return string     The number of members.
     */
    public function segmentationCount($id)
    {
        $parameters = ['id' => (string) $id];

        return (string) $this->soapClient->doCall('segmentationCount', $parameters);
    }

    /**
     * Counts the total number of distinct members in a segment (duplicate members are removed).
     *
     * @param  string $id The ID of the segment.
     *
     * @return string     The number of members.
     */
    public function segmentationDistinctCount($id)
    {
        $parameters = ['id' => (string) $id];

        return (string) $this->soapClient->doCall('segmentationDistinctCount', $parameters);
    }
}
