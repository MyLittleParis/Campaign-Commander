<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdSegmentService;

/**
 * CcmdSegmentServiceTest
 *
 * @author mylittleparis
 */
class CcmdSegmentServiceTest extends AbstractTestCase
{
    /**
     * @var ClientFactoryInterface
     */
    private $clientFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->clientFactory = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->clientFactory = null;

        parent::tearDown();
    }

    public function testSegmentationCreateSegment ()
    {
        $response = $this->getXMLFileMock('segmentationCreateSegmentResponse.xml');

        $name = 'test';
        $sampleType = 'ALL';

        $parameters = [
            'apiSegmentation' => [
                'name' => (string) $name,
                'sampleType' => (string) $sampleType
            ]
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationCreateSegment', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationCreateSegment($name, $sampleType)
        );
    }

    public function testSegmentationCreateSegmentWrongSampleType ()
    {
        $sampleType = 'NONE';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('segmentationCreateSegment')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $service->segmentationCreateSegment('name', $sampleType);
    }

    public function testSegmentationCreateSegmentWrongSampleRate ()
    {
        $sampleType = 'ALL';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('segmentationCreateSegment')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $service->segmentationCreateSegment('name', $sampleType);
    }

    public function testSegmentationDeleteSegment ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationDeleteSegmentResponse.xml');

        $id = '1';

        $parameters = ['difflistId' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationDeleteSegment', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationDeleteSegment($id)
        );
    }

    public function testSegmentationUpdateSegment ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateSegmentResponse.xml');

        $id = '1';
        $sampleType = 'ALL';

        $parameters = [
            'apiSegmentation' => [
                'id' => (string) $id,
                'sampleType' => (string) $sampleType
            ]
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateSegment', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateSegment($id, $sampleType)
        );
    }

    public function testSegmentationUpdateSegmentWrongSampleType ()
    {
        $sampleType = 'NONE';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('segmentationUpdateSegment')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $service->segmentationUpdateSegment('id', $sampleType);
    }

    public function testSegmentationUpdateSegmentWrongSampleRate ()
    {
        $sampleType = 'ALL';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('segmentationUpdateSegment')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $service->segmentationUpdateSegment('id', $sampleType);
    }

    public function testSegmentationAddStringDemographicCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddStringDemographicCriteriaByObjResponse.xml');

        $stringDemographicCriteria = array();

        $parameters = ['stringDemographicCriteria' => $stringDemographicCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddStringDemographicCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddStringDemographicCriteriaByObj($stringDemographicCriteria)
        );
    }

    public function testSegmentationAddNumericDemographicCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddNumericDemographicCriteriaByObjResponse.xml');

        $numericDemographicCriteria = array();

        $parameters = ['numericDemographicCriteria' => $numericDemographicCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddNumericDemographicCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddNumericDemographicCriteriaByObj($numericDemographicCriteria)
        );
    }

    public function testSegmentationAddDateDemographicCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddDateDemographicCriteriaByObjResponse.xml');

        $dateDemographicCriteria = array();

        $parameters = ['dateDemographicCriteria' => $dateDemographicCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddDateDemographicCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddDateDemographicCriteriaByObj($dateDemographicCriteria)
        );
    }

    public function testSegmentationAddCampaignActionCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddCampaignActionCriteriaByObjResponse.xml');

        $actionCriteria = array();

        $parameters = ['actionCriteria' => $actionCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddCampaignActionCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddCampaignActionCriteriaByObj($actionCriteria)
        );
    }

    public function testSegmentationAddCampaignTrackableLinkCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddCampaignTrackableLinkCriteriaByObjResponse.xml');

        $trackableLinkCriteria = array();

        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddCampaignTrackableLinkCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddCampaignTrackableLinkCriteriaByObj($trackableLinkCriteria)
        );
    }

    public function testSegmentationAddSerieActionCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddSerieActionCriteriaByObjResponse.xml');

        $actionCriteria = array();

        $parameters = ['actionCriteria' => $actionCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddSerieActionCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddSerieActionCriteriaByObj($actionCriteria)
        );
    }

    public function testSegmentationAddSerieTrackableLinkCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddSerieTrackableLinkCriteriaByObjResponse.xml');

        $trackableLinkCriteria = array();

        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddSerieTrackableLinkCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddSerieTrackableLinkCriteriaByObj($trackableLinkCriteria)
        );
    }

    public function testSegmentationAddSocialNetworkCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddSocialNetworkCriteriaByObjResponse.xml');

        $socialNetworkCriteria = array();

        $parameters = ['socialNetworkCriteria' => $socialNetworkCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddSocialNetworkCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddSocialNetworkCriteriaByObj($socialNetworkCriteria)
        );
    }

    public function testSegmentationAddRecencyCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddRecencyCriteriaByObjResponse.xml');

        $recencyCriteria = array();

        $parameters = ['recencyCriteria' => $recencyCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddRecencyCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddRecencyCriteriaByObj($recencyCriteria)
        );
    }

    public function testSegmentationAddDataMartCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationAddDataMartCriteriaByObjResponse.xml');

        $dataMartCriteria = array();

        $parameters = ['dataMartCriteria' => $dataMartCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationAddDataMartCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationAddDataMartCriteriaByObj($dataMartCriteria)
        );
    }

    public function testSegmentationGetSegmentById ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationGetSegmentByIdResponse.xml');

        $id = '1';

        $parameters = ['difflistId' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationGetSegmentById', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationGetSegmentById($id)
        );
    }

    public function testSegmentationGetSegmentList ()
    {
        $response = (array) $this->getXMLFileMock('segmentationGetSegmentListResponse.xml');

        $page = 1;
        $itemsPerPage = 1;

        $parameters = [
            'page' => (int) $page,
            'nbItemsPerPage' => (int) $itemsPerPage
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationGetSegmentList', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationGetSegmentList($page, $itemsPerPage)
        );
    }

    public function testSegmentationGetSegmentCriterias ()
    {
        $response = (array) $this->getXMLFileMock('segmentationGetSegmentCriteriasResponse.xml');

        $id = '1';

        $parameters = ['difflistId' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationGetSegmentCriterias', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationGetSegmentCriterias($id)
        );
    }

    public function testSegmentationGetPersoFragList ()
    {
        $response = (array) $this->getXMLFileMock('segmentationGetPersoFragListResponse.xml');

        $page = 1;
        $itemsPerPage = 1;

        $parameters = [
            'pageNumber' => (int) $page,
            'nbItemPerPage' => (int) $itemsPerPage
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationGetPersoFragList', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationGetPersoFragList($page, $itemsPerPage)
        );
    }

    public function testSegmentationDeleteCriteria ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationDeleteCriteriaResponse.xml');

        $id = '1';
        $orderCriteria = 1;

        $parameters = [
            'difflistId' => (string) $id,
            'orderCriteria' => (int) $orderCriteria
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationDeleteCriteria', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationDeleteCriteria($id, $orderCriteria)
        );
    }

    public function testSegmentationUpdateStringDemographicCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateStringDemographicCriteriaByObjResponse.xml');

        $stringDemographicCriteria = array();

        $parameters = ['stringDemographicCriteria' => $stringDemographicCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateStringDemographicCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateStringDemographicCriteriaByObj($stringDemographicCriteria)
        );
    }

    public function testSegmentationUpdateNumericDemographicCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateNumericDemographicCriteriaByObjResponse.xml');

        $numericDemographicCriteria = array();

        $parameters = ['numericDemographicCriteria' => $numericDemographicCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateNumericDemographicCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateNumericDemographicCriteriaByObj($numericDemographicCriteria)
        );
    }

    public function testSegmentationUpdateDateDemographicCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateDateDemographicCriteriaByObjResponse.xml');

        $dateDemographicCriteria = array();

        $parameters = ['dateDemographicCriteria' => $dateDemographicCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateDateDemographicCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateDateDemographicCriteriaByObj($dateDemographicCriteria)
        );
    }

    public function testSegmentationUpdateCampaignActionCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateCampaignActionCriteriaByObjResponse.xml');

        $actionCriteria = array();

        $parameters = ['actionCriteria' => $actionCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateCampaignActionCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateCampaignActionCriteriaByObj($actionCriteria)
        );
    }

    public function testSegmentationUpdateCampaignTrackableLinkCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateCampaignTrackableLinkCriteriaByObjResponse.xml');

        $trackableLinkCriteria = array();

        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateCampaignTrackableLinkCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateCampaignTrackableLinkCriteriaByObj($trackableLinkCriteria)
        );
    }

    public function testSegmentationUpdateSerieActionCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateSerieActionCriteriaByObjResponse.xml');

        $actionCriteria = array();

        $parameters = ['actionCriteria' => $actionCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateSerieActionCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateSerieActionCriteriaByObj($actionCriteria)
        );
    }

    public function testSegmentationUpdateSerieTrackableLinkCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateSerieTrackableLinkCriteriaByObjResponse.xml');

        $trackableLinkCriteria = array();

        $parameters = ['trackableLinkCriteria' => $trackableLinkCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateSerieTrackableLinkCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateSerieTrackableLinkCriteriaByObj($trackableLinkCriteria)
        );
    }

    public function testSegmentationUpdateSocialNetworkCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateSocialNetworkCriteriaByObjResponse.xml');

        $socialNetworkCriteria = array();

        $parameters = ['socialNetworkCriteria' => $socialNetworkCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateSocialNetworkCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateSocialNetworkCriteriaByObj($socialNetworkCriteria)
        );
    }

    public function testSegmentationUpdateRecencyCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateRecencyCriteriaByObjResponse.xml');

        $recencyCriteria = array();

        $parameters = ['recencyCriteria' => $recencyCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateRecencyCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateRecencyCriteriaByObj($recencyCriteria)
        );
    }

    public function testSegmentationUpdateDataMartCriteriaByObj ()
    {
        $response = (bool) $this->getXMLFileMock('segmentationUpdateDataMartCriteriaByObjResponse.xml');

        $dataMartCriteria = array();

        $parameters = ['dataMartCriteria' => $dataMartCriteria];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationUpdateDataMartCriteriaByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationUpdateDataMartCriteriaByObj($dataMartCriteria)
        );
    }

    public function testSegmentationCount()
    {
        $response = $this->getXMLFileMock('segmentationCountResponse.xml');

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationCount', ['id' => '1234'])
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationCount('1234')
        );
    }

    public function testSegmentationDistinctCount()
    {
        $response = $this->getXMLFileMock('segmentationDistinctCountResponse.xml');

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('segmentationDistinctCount', ['id' => '1234'])
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdSegmentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->segmentationDistinctCount('1234')
        );
    }
}
