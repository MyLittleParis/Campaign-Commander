<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdDynamicContentBlockLinkService;

/**
 * CcmdDynamicContentBlockLinkServiceTest
 *
 * @author mylittleparis
 */
class CcmdDynamicContentBlockLinkServiceTest extends AbstractTestCase
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


    public function testCreateStandardBannerLink ()
    {
        $response = $this->getXMLFileMock('createStandardBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $url = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
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
            ->with('createStandardBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createStandardBannerLink(
                $id,
                $name,
                $url
            )
        );
    }
    
    public function testCreateAndAddStandardBannerLink ()
    {
        $response = $this->getXMLFileMock('createAndAddStandardBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $url = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
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
            ->with('createAndAddStandardBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddStandardBannerLink(
                $id,
                $name,
                $url
            )
        );
    }
    
    public function testCreateUnsubscribeBannerLink ()
    {
        $response = $this->getXMLFileMock('createUnsubscribeBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $pageOk = 'test';
        $messageOk = 'test';
        $pageError = 'test';
        $messageError = 'test';
    
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createUnsubscribeBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createUnsubscribeBannerLink(
                $id,
                $name,
                $pageOk,
                $messageOk,
                $pageError,
                $messageError
            )
        );
    }
    
    public function testCreateAndAddUnsubscribeBannerLink ()
    {
        $response = $this->getXMLFileMock('createAndAddUnsubscribeBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $pageOk = 'test';
        $messageOk = 'test';
        $pageError = 'test';
        $messageError = 'test';
    
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddUnsubscribeBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddUnsubscribeBannerLink(
                $id,
                $name,
                $pageOk,
                $messageOk,
                $pageError,
                $messageError
            )
        );
    }
    
    public function testCreatePersonalisedBannerLink ()
    {
        $response = $this->getXMLFileMock('createPersonalisedBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $url = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
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
            ->with('createPersonalisedBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createPersonalisedBannerLink(
                $id,
                $name,
                $url
            )
        );
    }
    
    public function testCreateAndAddPersonalisedBannerLink ()
    {
        $response = $this->getXMLFileMock('createAndAddPersonalisedBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $url = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
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
            ->with('createAndAddPersonalisedBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddPersonalisedBannerLink(
                $id,
                $name,
                $url
            )
        );
    }
    
    public function testCreateUpdateBannerLink ()
    {
        $response = $this->getXMLFileMock('createUpdateBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $parameters = 'test';
        $pageOk = 'test';
        $messageOk = 'test';
        $pageError = 'test';
        $messageError = 'test';
        
        $parametersTest = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'parameters' => $parameters
        ];

        if (null !== $pageOk) {
            $parametersTest['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parametersTest['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parametersTest['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parametersTest['messageError'] = (string) $messageError;
        }

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createUpdateBannerLink', $parametersTest)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createUpdateBannerLink(
                $id,
                $name,
                $parameters,
                $pageOk,
                $messageOk,
                $pageError,
                $messageError
            )
        );
    }
    
    public function testCreateAndAddUpdateBannerLink ()
    {
        $response = $this->getXMLFileMock('createAndAddUpdateBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $parameters = 'test';
        $pageOk = 'test';
        $messageOk = 'test';
        $pageError = 'test';
        $messageError = 'test';
    
        $parametersTest = [
            'bannerId' => (string) $id,
            'name' => (string) $name,
            'parameters' => $parameters
        ];

        if (null !== $pageOk) {
            $parametersTest['pageOK'] = (string) $pageOk;
        }

        if (null !== $messageOk) {
            $parametersTest['messageOK'] = (string) $messageOk;
        }

        if (null !== $pageError) {
            $parametersTest['pageError'] = (string) $pageError;
        }

        if (null !== $messageError) {
            $parametersTest['messageError'] = (string) $messageError;
        }

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddUpdateBannerLink', $parametersTest)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddUpdateBannerLink(
                $id,
                $name,
                $parameters,
                $pageOk,
                $messageOk,
                $pageError,
                $messageError
            )
        );
    }
    
    public function testCreateActionBannerLink ()
    {
        $response = $this->getXMLFileMock('createActionBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $action = 'test';
        $pageOk = 'test';
        $messageOk = 'test';
        $pageError = 'test';
        $messageError = 'test';
    
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createActionBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createActionBannerLink(
                $id,
                $name,
                $action,
                $pageOk,
                $messageOk,
                $pageError,
                $messageError
            )
        );
    }
    
    public function testCreateAndAddActionBannerLink ()
    {
        $response = $this->getXMLFileMock('createAndAddActionBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
        $action = 'test';
        $pageOk = 'test';
        $messageOk = 'test';
        $pageError = 'test';
        $messageError = 'test';
    
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddActionBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddActionBannerLink(
                $id,
                $name,
                $action,
                $pageOk,
                $messageOk,
                $pageError,
                $messageError
            )
        );
    }
    
    public function testCreateMirrorBannerLink ()
    {
        $response = $this->getXMLFileMock('createMirrorBannerLinkResponse.xml');

        $id = '1';
        $name = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createMirrorBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createMirrorBannerLink($id, $name)
        );
    }
    
    public function testCreateAndAddMirrorBannerLink ()
    {
        $response = $this->getXMLFileMock('createAndAddMirrorBannerLinkResponse.xml');

        $id = 'test';
        $name = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
            'name' => (string) $name
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createAndAddMirrorBannerLink', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createAndAddMirrorBannerLink($id, $name)
        );
    }
    
    public function testUpdateBannerLinkByField ()
    {
        $response = (bool) $this->getXMLFileMock('updateBannerLinkByFieldResponse.xml');

        $id = '1';
        $order = 'test';
        $field = 'test';
        $value = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
            'order' => (string) $order,
            'field' => (string) $field
        ];

        if (null !== $value) {
            $parameters['value'] = $value;
        }

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('updateBannerLinkByField', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateBannerLinkByField(
                $id,
                $order,
                $field,
                $value
            )
        );
    }
    
    public function testGetBannerLinkByOrder ()
    {
        $response = (array) $this->getXMLFileMock('getBannerLinkByOrderResponse.xml');

        $id = '1';
        $order = 'test';
    
        $parameters = [
            'bannerId' => (string) $id,
            'order' => (string) $order
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getBannerLinkByOrder', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentBlockLinkService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getBannerLinkByOrder($id, $order)
        );
    }
}