<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdURLService;

/**
 * CcmdURLServiceTest
 *
 * @author mylittleparis
 */
class CcmdURLServiceTest extends AbstractTestCase
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


    public function testCreateStandardUrl ()
    {
        $response = (int) $this->getXMLFileMock('createStandardUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$url = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createStandardUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createStandardUrl(
        		$messageId,
        		$name,
        		$url
            )
        );
    }
    
    public function testCreateAndAddStandardUrl ()
    {
        $response = (int) $this->getXMLFileMock('createAndAddStandardUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$url = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddStandardUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddStandardUrl(
        		$messageId,
        		$name,
        		$url
            )
        );
    }
    
    public function testCreateUnsubscribeUrl ()
    {
        $response = (int) $this->getXMLFileMock('createUnsubscribeUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$pageOk = 'test';
    	$messageOk = 'test';
    	$pageError = 'test';
    	$messageError = 'test';
	
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createUnsubscribeUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createUnsubscribeUrl(
        		$messageId,
        		$name,
        		$pageOk,
        		$messageOk,
        		$pageError,
        		$messageError
            )
        );
    }
    
    public function testCreateAndAddUnsubscribeUrl ()
    {
        $response = (int) $this->getXMLFileMock('createAndAddUnsubscribeUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$pageOk = 'test';
    	$messageOk = 'test';
    	$pageError = 'test';
	    $messageError = 'test';
	
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddUnsubscribeUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddUnsubscribeUrl(
        		$messageId,
        		$name,
        		$pageOk,
        		$messageOk,
        		$pageError,
        		$messageError
            )
        );
    }
    
    public function testCreatePersonalisedUrl ()
    {
        $response = (int) $this->getXMLFileMock('createPersonalisedUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$url = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createPersonalisedUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createPersonalisedUrl(
        		$messageId,
        		$name,
        		$url
            )
        );
    }
    
    public function testCreateAndAddPersonalisedUrl ()
    {
        $response = (int) $this->getXMLFileMock('createAndAddPersonalisedUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$url = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'url' => (string) $url
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddPersonalisedUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddPersonalisedUrl(
        		$messageId,
        		$name,
        		$url
            )
        );
    }
    
    public function testCreateUpdateUrl ()
    {
        $response = (int) $this->getXMLFileMock('createUpdateUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$parameters = 'test';
    	$pageOk = 'test';
    	$messageOk = 'test';
    	$pageError = 'test';
    	$messageError = 'test';
	
        $parametersTest = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'parameters' => $parameters,
            'pageOK' => (string) $pageOk,
            'messageOK' => (string) $messageOk,
            'pageError' => (string) $pageError,
            'messageError' => (string) $messageError
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createUpdateUrl', $parametersTest)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createUpdateUrl(
        		$messageId,
        		$name,
        		$parameters,
        		$pageOk,
        		$messageOk,
        		$pageError,
        		$messageError
            )
        );
    }
    
    public function testCreateAndAddUpdateUrl ()
    {
        $response = (int) $this->getXMLFileMock('createAndAddUpdateUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$parameters = 'test';
    	$pageOk = 'test';
    	$messageOk = 'test';
    	$pageError = 'test';
    	$messageError = 'test';
	
        $parametersTest = [
            'messageId' => (string) $messageId,
            'name' => (string) $name,
            'parameters' => $parameters,
            'pageOK' => (string) $pageOk,
            'messageOK' => (string) $messageOk,
            'pageError' => (string) $pageError,
            'messageError' => (string) $messageError
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddUpdateUrl', $parametersTest)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddUpdateUrl(
        		$messageId,
        		$name,
        		$parameters,
        		$pageOk,
        		$messageOk,
        		$pageError,
        		$messageError
            )
        );
    }
    
    public function testCreateActionUrl ()
    {
        $response = (int) $this->getXMLFileMock('createActionUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$action = 'test';
    	$pageOk = 'test';
    	$messageOk = 'test';
    	$pageError = 'test';
    	$messageError = 'test';
	
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createActionUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createActionUrl(
        		$messageId,
        		$name,
        		$action,
        		$pageOk,
        		$messageOk,
        		$pageError,
        		$messageError
            )
        );
    }
    
    public function testCreatedAndAddActionUrl ()
    {
        $response = (int) $this->getXMLFileMock('createdAndAddActionUrlResponse.xml');

        $messageId = '1';
    	$name = 'test';
    	$action = 'test';
    	$pageOk = 'test';
    	$messageOk = 'test';
    	$pageError = 'test';
    	$messageError = 'test';
	
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createdAndAddActionUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createdAndAddActionUrl(
        		$messageId,
        		$name,
        		$action,
        		$pageOk,
        		$messageOk,
        		$pageError,
        		$messageError
            )
        );
    }
    
    public function testCreateMirrorUrl ()
    {
        $response = (int) $this->getXMLFileMock('createMirrorUrlResponse.xml');

        $messageId = '1';
	    $name = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createMirrorUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createMirrorUrl($messageId, $name)
        );
    }
    
    public function testCreateAndAddMirrorUrl ()
    {
        $response = (int) $this->getXMLFileMock('createAndAddMirrorUrlResponse.xml');

        $messageId = '1';
	    $name = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'name' => (string) $name
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddMirrorUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddMirrorUrl($messageId, $name)
        );
    }
    
    public function testAddShareLink ()
    {
        $response = (bool) $this->getXMLFileMock('addShareLinkResponse.xml');

        $messageId = '1';
    	$linkType = 'test';
    	$buttonUrl = 'test';
    	$language = 1;
	
        $parameters = [
            'messageId' => (string) $messageId,
            'linkType' => (bool) $linkType
        ];

        if (null !== $buttonUrl) {
            $parameters['buttonUrl'] = (string) $buttonUrl;
        }

        // Check if language is valid
        if (null !== $language) {
             $parameters['language'] = (string) $language;
        }

    	if (null !== $buttonUrl) {
            $parameters['buttonUrl'] = (string) $buttonUrl;
        }

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('addShareLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->addShareLink(
        		$messageId,
        		$linkType,
        		$buttonUrl,
        		$language
            )
        );
    }
    
    public function testAddShareLinkWrongLanguage ()
    {
        $messageId = '1';
        $linkType = 'test';
        $buttonUrl = 'test';
        $language = 1500;

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('addShareLink')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $service->addShareLink(
        	$messageId,
        	$linkType,
        	$buttonUrl,
        	$language
        );
    }
    
    public function testUpdateUrlByField ()
    {
        $response = (bool) $this->getXMLFileMock('updateUrlByFieldResponse.xml');

        $messageId = '1';
    	$order = 'test';
    	$field = 'test';
    	$value = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'order' => (int) $order,
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
            ->with('updateUrlByField', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateUrlByField(
        		$messageId,
        		$order,
        		$field,
        		$value
            )
        );
    }
    
    public function testDeleteUrl ()
    {
        $response = (bool) $this->getXMLFileMock('deleteUrlResponse.xml');

        $messageId = '1';
	    $order = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'order' => (int) $order
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('deleteUrl', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->deleteUrl($messageId, $order)
        );
    }
    
    public function testGetUrlByOrder ()
    {
        $response = (array) $this->getXMLFileMock('getUrlByOrderResponse.xml');

        $messageId = '1';
    	$order = 'test';
	
        $parameters = [
            'messageId' => (string) $messageId,
            'order' => (int) $order
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getUrlByOrder', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdURLService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getUrlByOrder($messageId, $order)
        );
    }   
}