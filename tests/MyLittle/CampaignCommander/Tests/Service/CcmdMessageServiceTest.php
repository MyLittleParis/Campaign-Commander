<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdMessageService;

/**
 * CcmdMessageServiceTest
 *
 * @author mylittleparis
 */
class CcmdMessageServiceTest extends AbstractTestCase
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


    public function testCreateEmailMessage ()
    {
        $response = (string) $this->getXMLFileMock('createEmailMessageResponse.xml');

        $name = 'test';
    	$description = 'test';
    	$subject = 'test';
    	$from = 'test';
    	$fromEmail = 'test';
    	$to = 'test';
    	$body = 'test';
    	$encoding = 'test';
    	$replyTo = 'test';
    	$replyToEmail = 'test';
    	$bounceback = true;
    	$unsubscribe = true;
    	$unsublinkpage = 'test';

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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createEmailMessage', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createEmailMessage(
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
        		$bounceback,
        		$unsubscribe,
        		$unsublinkpage
            )
        );
    }
    
    public function testCreateEmailMessageByObj ()
    {
        $response = (string) $this->getXMLFileMock('createEmailMessageByObjResponse.xml');

        $message = array();
	
        $parameters = ['message' => $message ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createEmailMessageByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createEmailMessageByObj($message)
        );
    }
    
    public function testCreateSmsMessage ()
    {
        $response = (string) $this->getXMLFileMock('createSmsMessageResponse.xml');

        $name = 'test';
    	$desc = 'test';
    	$from = 'test';
    	$body = 'test';
	
        $parameters = [
            'name' => (string) $name,
            'desc' => (string) $desc,
            'from' => (string) $from,
            'body' => (string) $body
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createSmsMessage', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createSmsMessage(
        		$name,
        		$desc,
        		$from,
        		$body
            )
        );
    }
    
    public function testCreateSmsMessageByObj ()
    {
        $response = (string) $this->getXMLFileMock('createSmsMessageByObjResponse.xml');

        $message = array();
	
        $parameters = ['message' => $message ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createSmsMessageByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createSmsMessageByObj($message)
        );
    }
    
    public function testDeleteMessage ()
    {
        $response = (bool) $this->getXMLFileMock('deleteMessageResponse.xml');

        $id = '1';
	
        $parameters = ['id' => $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('deleteMessage', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->deleteMessage($id)
        );
    }
    
    public function testUpdateMessage ()
    {
        $response = (bool) $this->getXMLFileMock('updateMessageResponse.xml');

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
            ->with('updateMessage', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateMessage(
        		$id,
        		$field,
        		$value
            )
        );
    }
    
    public function testUpdateMessageByObj ()
    {
        $response = (bool) $this->getXMLFileMock('updateMessageByObjResponse.xml');

        $message = array();
	
        $parameters = ['message' => $message];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('updateMessageByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateMessageByObj($message)
        );
    }
    
    public function testCloneMessage ()
    {
        $response = (string) $this->getXMLFileMock('cloneMessageResponse.xml');

        $id = '1';
	    $newName = 'test';
	
        $parameters = [
            'id' => (string) $id,
            'newName' => (string) $newName
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('cloneMessage', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->cloneMessage($id, $newName)
        );
    }
    
    public function testGetMessage ()
    {
        $response = (string) $this->getXMLFileMock('getMessageResponse.xml');

        $id = 'test';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getMessage', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getMessage(
		$id
            )
        );
    }
    
    public function testGetLastEmailMessages ()
    {
        $response = (array) $this->getXMLFileMock('getLastEmailMessagesResponse.xml');

        $limit = 500;
	
        $parameters = ['limit' => (int) $limit];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getLastEmailMessages', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getLastEmailMessages($limit)
        );
    }
    
    public function testGetLastSmsMessages ()
    {
        $response = (array) $this->getXMLFileMock('getLastSmsMessagesResponse.xml');

        $limit = 500;
	
        $parameters = ['limit' => (int) $limit];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getLastSmsMessages', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getLastSmsMessages($limit)
        );
    }
    
    public function testGetEmailMessagesByField ()
    {
        $response = (array) $this->getXMLFileMock('getEmailMessagesByFieldResponse.xml');

        $field = 'test';
    	$value = 1;
    	$limit = 500;
	
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
            ->with('getEmailMessagesByField', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getEmailMessagesByField(
        		$field,
        		$value,
        		$limit
            )
        );
    }
    
    public function testGetSmsMessagesByField ()
    {
        $response = (array) $this->getXMLFileMock('getSmsMessagesByFieldResponse.xml');

        $field = 'test';
    	$value = 1;
    	$limit = 500;
	
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
            ->with('getSmsMessagesByField', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getSmsMessagesByField(
        		$field,
        		$value,
        		$limit
            )
        );
    }
    
    public function testGetMessagesByPeriod ()
    {
        $response = (array) $this->getXMLFileMock('getMessagesByPeriodResponse.xml');

        $dateBegin = 1;
    	$dateEnd = 10;
	
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
            ->with('getMessagesByPeriod', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getMessagesByPeriod($dateBegin, $dateEnd)
        );
    }
    
    public function testGetEmailMessagePreview ()
    {
        $response = (string) $this->getXMLFileMock('getEmailMessagePreviewResponse.xml');

        $messageId = '1';
	    $part = 'HTML';
	
        $parameters = [
            'id' => (string) $messageId,
            'part' => $part
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getEmailMessagePreview', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getEmailMessagePreview($messageId, $part)
        );
    }
    
    public function testGetEmailMessagePreviewWrongPart ()
    {
        $messageId = '1';
        $part = 'NONE';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('getEmailMessagePreview')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $service->getEmailMessagePreview($messageId, $part);
    }
    
    public function testGetSmsMessagePreview ()
    {
        $response = (string) $this->getXMLFileMock('getSmsMessagePreviewResponse.xml');

        $messageId = '1';
	
        $parameters = ['id' => (string) $messageId];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getSmsMessagePreview', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getSmsMessagePreview($messageId)
        );
    }
    
    public function testTrackAllLinks ()
    {
        $response = (string) $this->getXMLFileMock('trackAllLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('trackAllLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->trackAllLinks($id)
        );
    }
    
    public function testUntrackAllLinks ()
    {
        $response = (bool) $this->getXMLFileMock('untrackAllLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('untrackAllLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->untrackAllLinks($id)
        );
    }
    
    public function testTrackLinkByPosition ()
    {
        $response = (string) $this->getXMLFileMock('trackLinkByPositionResponse.xml');

        $id = '1';
    	$position = 'test';
    	$part = 'HTML';
	
        $parameters = [
            'id' => (string) $id,
            'position' => (string) $position,
            'part' => (string) $part
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('trackLinkByPosition', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->trackLinkByPosition(
        		$id,
        		$position,
        		$part
            )
        );
    }
    
    public function testTrackLinkByPositionWrongPart ()
    {
        $id = '1';
        $position = 'test';
        $part = 'NONE';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('trackLinkByPosition')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $service->trackLinkByPosition(
        		$id,
        		$position,
        		$part
            );
    }
    
    public function testGetAllTrackedLinks ()
    {
        $response = (array) $this->getXMLFileMock('getAllTrackedLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getAllTrackedLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getAllTrackedLinks($id)
        );
    }
    
    public function testGetAllUnusedTrackedLinks ()
    {
        $response = (array) $this->getXMLFileMock('getAllUnusedTrackedLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getAllUnusedTrackedLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getAllUnusedTrackedLinks($id)
        );
    }
    
    public function testGetAllTrackableLinks ()
    {
        $response = (array) $this->getXMLFileMock('getAllTrackableLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getAllTrackableLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getAllTrackableLinks($id)
        );
    }
    
    public function testTestEmailMessageByGroup ()
    {
        $response = (bool) $this->getXMLFileMock('testEmailMessageByGroupResponse.xml');

        $id = '1';
    	$groupId = '1';
    	$campaignName = 'test';
    	$subject = 'test';
    	$part = 'HTML';
	
        $parameters = [
            'id' => (string) $id,
            'groupId' => (string) $groupId,
            'campaignName' => (string) $campaignName,
            'subject' => (string) $subject,
            'part' => (string) $part
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('testEmailMessageByGroup', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->testEmailMessageByGroup(
        		$id,
        		$groupId,
        		$campaignName,
        		$subject,
        		$part
            )
        );
    }
    
    public function testTestEmailMessageByGroupWrongPart ()
    {
        $id = '1';
        $groupId = '1';
        $campaignName = 'test';
        $subject = 'test';
        $part = 'NONE';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('testEmailMessageByGroup')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $service->testEmailMessageByGroup(
        		$id,
        		$groupId,
        		$campaignName,
        		$subject,
        		$part
            );
    }
    
    public function testTestEmailMessageByMember ()
    {
        $response = (bool) $this->getXMLFileMock('testEmailMessageByMemberResponse.xml');

        $id = '1';
    	$memberId = '1';
    	$campaignName = 'test';
    	$subject = 'test';
    	$part = 'HTML';
	
        $parameters = [
            'id' => (string) $id,
            'memberId' => (string) $memberId,
            'campaignName' => (string) $campaignName,
            'subject' => (string) $subject,
            'part' => (string) $part
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('testEmailMessageByMember', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->testEmailMessageByMember(
        		$id,
        		$memberId,
        		$campaignName,
        		$subject,
        		$part
            )
        );
    }
    
    public function testTestEmailMessageByMemberWrongPart ()
    {
        $id = '1';
        $memberId = '1';
        $campaignName = 'test';
        $subject = 'test';
        $part = 'NONE';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('testEmailMessageByMember')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $service->testEmailMessageByMember(
        		$id,
        		$memberId,
        		$campaignName,
        		$subject,
        		$part
            );
    }
    
    public function testTestSmsMessage ()
    {
        $response = (bool) $this->getXMLFileMock('testSmsMessageResponse.xml');

        $id = '1';
    	$memberId = '1';
    	$campaignName = 'test';
	
        $parameters = [
            'id' => (string) $id,
            'memberId' => (string) $memberId,
            'campaignName' => (string) $campaignName
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('testSmsMessage', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->testSmsMessage(
        		$id,
        		$memberId,
        		$campaignName
            )
        );
    }
    
    public function testGetDefaultSender ()
    {
        $response = (string) $this->getXMLFileMock('getDefaultSenderResponse.xml');

        $parameters = array();

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getDefaultSender', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getDefaultSender()
        );
    }
    
    public function testGetValidatedAltSenders ()
    {
        $response = (array) $this->getXMLFileMock('getValidatedAltSendersResponse.xml');

        $parameters = array();        

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getValidatedAltSenders', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getValidatedAltSenders()
        );
    }
    
    public function testGetNotValidatedSenders ()
    {
        $response = (array) $this->getXMLFileMock('getNotValidatedSendersResponse.xml');

        $parameters = array();

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getNotValidatedSenders', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdMessageService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getNotValidatedSenders()
        );
    }   
}