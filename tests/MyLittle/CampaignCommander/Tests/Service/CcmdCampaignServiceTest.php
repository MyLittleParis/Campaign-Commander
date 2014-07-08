<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdCampaignService;

/**
 * CcmdCampaignServiceTest
 *
 * @author mylittleparis
 */
class CcmdCampaignServiceTest extends AbstractTestCase
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

        $this->clientFactory = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\Model\ClientFactoryInterface')
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

    public function testCreateCampaign()
    {
    	$response = (int) $this->getXMLFileMock('createCampaignResponse.xml');

    	$name = 'test';
    	$sendDate = 23;
    	$messageId = '45';
    	$mailingListId = '78';
    	$notifProgress = true;
    	$postClickTracking = true;
    	$emaildedupflg = true;
    	$description = 'test';

    	$parameters = [
            'name' => (string) $name,
            'sendDate' => date('Y-m-d H:i:s', (int) $sendDate),
            'messageId' => (string) $messageId,
            'mailingListId' => (string) $mailingListId,
            'notifProgress' => (bool) $notifProgress,
            'postClickTracking' => (bool) $postClickTracking,
            'emaildedupflg' => (bool) $emaildedupflg,
            'desc' => (string) $description
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createCampaign(
	            $name, 
	            $sendDate, 
	            $messageId, 
	            $mailingListId, 
	            $description, 
	            $notifProgress, 
	            $postClickTracking, 
	            $emaildedupflg    
            )
        );
    }

    public function testCreateCampaignWithAnalytics()
    {
    	$response = (int) $this->getXMLFileMock('createCampaignWithAnalyticsResponse.xml');

    	$name = 'test';
    	$sendDate = 23;
    	$messageId = '45';
    	$mailingListId = '78';
    	$notifProgress = true;
    	$postClickTracking = true;
    	$emaildedupflg = true;
    	$description = 'test';

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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createCampaignWithAnalytics', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createCampaignWithAnalytics(
	            $name, 
	            $sendDate, 
	            $messageId, 
	            $mailingListId, 
	            $description, 
	            $notifProgress, 
	            $postClickTracking, 
	            $emaildedupflg    
            )
        );
    }

    public function testCreateCampaignByObj ()
    {
    	$response = (int) $this->getXMLFileMock('createCampaignByObjResponse.xml');

    	$campaign = array();

    	$parameters = ['campaign' => $campaign];

    	$apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createCampaignByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createCampaignByObj($campaign)
        );
    }

    public function testDeleteCampaign ()
    {
    	$response = (bool) $this->getXMLFileMock('deleteCampaignResponse.xml');

    	$id = '1';

    	$parameters = ['id' => (string) $id];

    	$apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('deleteCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->deleteCampaign($id)
        );
    }

    public function testUpdateCampaign ()
    {
        $response = (bool) $this->getXMLFileMock('updateCampaignResponse.xml');

        $id = '1';
        $field = 'test';
        $value = 'test';

        $parameters = [
            'id' => (string) $id,
            'field' => (string) $field,
            'value' => $value
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('updateCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateCampaign(
                $id, 
                $field, 
                $value
            )
        );
    }

    public function testUpdateCampaignbyObj ()
    {
        $response = (bool) $this->getXMLFileMock('updateCampaignByObjResponse.xml');

        $campaign = array();

        $parameters = ['campaign' => $campaign];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('updateCampaignByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateCampaignByObj($campaign)
        );
    }

    public function testPostCampaign ()
    {
        $response = (bool) $this->getXMLFileMock('postCampaignResponse.xml');

        $id = '1';

        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('postCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->postCampaign($id)
        );
    }

    public function testUnpostCampaign ()
    {
        $response = (bool) $this->getXMLFileMock('unpostCampaignResponse.xml');

        $id = '1';

        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('unpostCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->unpostCampaign($id)
        );
    }

    public function testGetCampaign ()
    {
        $response = (string) $this->getXMLFileMock('getCampaignResponse.xml');

        $id = '1';

        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getCampaign($id)
        );
    }

    public function testGetCampaignsByField ()
    {
        $response = (array) $this->getXMLFileMock('getCampaignByFieldResponse.xml');

        $field = 'test';
        $value = 'test';
        $limit = 1;

        $parameters = [
            'field' => (string) $field,
            'value' => $value,
            'limit' => (int) $limit
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getCampaignsByField', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getCampaignsByField(
                $field, 
                $value, 
                $limit
            )
        );
    }

    public function testGetCampaignsByStatus ()
    {
        $response = (array) $this->getXMLFileMock('getCampaignByStatusResponse.xml');

        $status = 'RUNNING';

        $parameters = ['status' => (string) $status];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getCampaignsByStatus', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getCampaignsByStatus($status)
        );
    }

    public function testGetCampaignsByStatusWrongCase ()
    {
        $status = 'NONE';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('getCampaignsByStatus')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $service->getCampaignsByStatus($status);
    }

    public function testGetCampaignsByPeriod()
    {
        $response = (array) $this->getXMLFileMock('getCampaignByPeriodResponse.xml');

        $dateBegin = 1;
        $dateEnd = 2;

        $parameters = [
            'dateBegin' => date('Y-m-d H:i:s', (int) $dateBegin),
            'dateEnd' => date('Y-m-d H:i:s', (int) $dateEnd)
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getCampaignsByPeriod', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getCampaignsByPeriod($dateBegin, $dateEnd)
        );
    }

    public function testgetCampaignStatus ()
    {
        $response = (string) $this->getXMLFileMock('getCampaignStatusResponse.xml');

        $id = '1';

        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getCampaignStatus', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getCampaignStatus($id)
        );
    }

    public function testGetLastCampaigns ()
    {
        $response = (array) $this->getXMLFileMock('getLastCampaignsResponse.xml');

        $limit = 1;

        $parameters = ['limit' => (int) $limit];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getLastCampaigns', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getLastCampaigns($limit)
        );
    }

    public function testTestCampaignByGroup ()
    {
        $response = (bool) $this->getXMLFileMock('testCampaignByGroupResponse.xml');

        $id = '1';
        $groupId = '1';

        $parameters = [
            'id' => (string) $id,
            'groupId' => (string) $groupId
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('testCampaignByGroup', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->testCampaignByGroup($id, $groupId)
        );
    }

    public function testTestCampaignByMember ()
    {
        $response = (bool) $this->getXMLFileMock('testCampaignByMemberResponse.xml');

        $id = '1';
        $memberId = '1';

        $parameters = [
            'id' => (string) $id,
            'memberId' => (string) $memberId
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('testCampaignByMember', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->testCampaignByMember($id, $memberId)
        );
    }

    public function testPauseCampaign ()
    {
        $response = (bool) $this->getXMLFileMock('pauseCampaignResponse.xml');
        
        $id = '1';

        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('pauseCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->pauseCampaign($id)
        );
    } 

    public function testUnpauseCampaign ()
    {
        $response = (bool) $this->getXMLFileMock('unpauseCampaignResponse.xml');
        
        $id = '1';

        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('unpauseCampaign', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->unpauseCampaign($id)
        );
    }

    public function testGetCampaignSnapshotReport ()
    {
        $response = (array) $this->getXMLFileMock('getCampaignSnapshotReportResponse.xml');
        
        $id = '1';

        $parameters = ['campaignId' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getCampaignSnapshotReport', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdCampaignService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getCampaignSnapshotReport($id)
        );
    }
}