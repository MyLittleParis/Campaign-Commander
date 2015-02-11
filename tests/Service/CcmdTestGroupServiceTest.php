<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdTestGroupService;

/**
 * CcmdTestGroupServiceTest
 *
 * @author mylittleparis
 */
class CcmdTestGroupServiceTest extends AbstractTestCase
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


    public function testCreateTestGroup ()
    {
        $response = (string) $this->getXMLFileMock('createTestGroupResponse.xml');

        $name = 'test';
	
        $parameters = ['Name' => (string) $name];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createTestGroup', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createTestGroup($name)
        );
    }
    
    public function testCreateTestGroupByObj ()
    {
        $response = (string) $this->getXMLFileMock('createTestGroupByObjResponse.xml');

        $testGroup = array();
	
        $parameters = ['testGroup' => $testGroup];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createTestGroupByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createTestGroupByObj($testGroup)
        );
    }
    
    public function testAddTestMember ()
    {
        $response = (bool) $this->getXMLFileMock('addTestMemberResponse.xml');

        $memberId = '1';
	    $groupId = '1';
	
        $parameters = [
            'memberId' => (string) $memberId,
            'groupId' => (string) $groupId
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('addTestMember', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->addTestMember($memberId, $groupId)
        );
    }
    
    public function testRemoveTestMember ()
    {
        $response = (bool) $this->getXMLFileMock('removeTestMemberResponse.xml');

        $memberId = '1';
	    $groupId = '1';
	
        $parameters = [
            'memberId' => (string) $memberId,
            'groupId' => (string) $groupId
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('removeTestMember', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->removeTestMember($memberId, $groupId)
        );
    }
    
    public function testDeleteTestGroup ()
    {
        $response = (bool) $this->getXMLFileMock('deleteTestGroupResponse.xml');

        $groupId = '1';
	
        $parameters = ['id' => (string) $groupId];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('deleteTestGroup', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->deleteTestGroup($groupId)
        );
    }
    
    public function testUpdateTestGroupByObj ()
    {
        $response = (bool) $this->getXMLFileMock('updateTestGroupByObjResponse.xml');

        $testGroup = array();
	
        $parameters = ['testGroup' => $testGroup];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('updateTestGroupByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateTestGroupByObj($testGroup)
        );
    }
    
    public function testGetTestGroup ()
    {
        $response = (array) $this->getXMLFileMock('getTestGroupResponse.xml');

        $groupId = '1';
	
        $parameters = ['id' => (string) $groupId];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getTestGroup', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getTestGroup($groupId)
        );
    }
    
    public function testGetClientTestGroups ()
    {
        $response = (array) $this->getXMLFileMock('getClientTestGroupsResponse.xml');

        $parameters = array();

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getClientTestGroups', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdTestGroupService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getClientTestGroups()
        );
    }   
}