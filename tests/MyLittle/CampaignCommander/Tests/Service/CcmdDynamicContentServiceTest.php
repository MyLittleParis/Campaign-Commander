<?php

namespace MyLittle\CampaignCommander\Tests\Service;

use MyLittle\CampaignCommander\Tests\AbstractTestCase;
use MyLittle\CampaignCommander\Service\CcmdDynamicContentService;

/**
 * CcmdDynamicContentServiceTest
 *
 * @author mylittleparis
 */
class CcmdDynamicContentServiceTest extends AbstractTestCase
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


    public function testCreateBanner ()
    {
        $response = (string) $this->getXMLFileMock('createBannerResponse.xml');

        $name = 'test';
    	$contentType = 'HTML';
    	$content = 'test';
    	$description = 'test';
	
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

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createBanner', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createBanner(
        		$name,
        		$contentType,
        		$content,
        		$description
            )
        );
    }
    
    public function testCreateBannerWrongContentType ()
    {
        $name = 'test';
        $contentType = 'NONE';
        $content = 'test';
        $description = 'test';

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('createBanner')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $service->createBanner(
        		$name,
        		$contentType,
        		$content,
        		$description
            );
    }
    
    public function testCreateBannerByObj ()
    {
        $response = (string) $this->getXMLFileMock('createBannerByObjResponse.xml');

        $banner = array();
	
        $parameters = ['banner' => $banner];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('createBannerByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->createBannerByObj($banner)
        );
    }
    
    public function testDeleteBanner ()
    {
        $response = (bool) $this->getXMLFileMock('deleteBannerResponse.xml');

        $id = 'test';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('deleteBanner', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->deleteBanner($id)
        );
    }
    
    public function testUpdateBanner ()
    {
        $response = (bool) $this->getXMLFileMock('updateBannerResponse.xml');

        $id = 'test';
    	$field = 'test';
    	$value = 'test';
	
        $parameters = [
            'id' => (string) $id,
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
            ->with('updateBanner', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateBanner(
        		$id,
        		$field,
        		$value
            )
        );
    }
    
    public function testUpdateBannerByObj ()
    {
        $response = (bool) $this->getXMLFileMock('updateBannerByObjResponse.xml');

        $banner = array();
	
        $parameters = ['banner' => $banner];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('updateBannerByObj', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->updateBannerByObj($banner)
        );
    }
    
    public function testCloneBanner ()
    {
        $response = (string) $this->getXMLFileMock('cloneBannerResponse.xml');

        $id = '1';
	    $name = 'test';
	
        $parameters = [
            'id' => (string) $id,
            'newName' => (string) $name
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('cloneBanner', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->cloneBanner($id, $name)
        );
    }
    
    public function testGetBannerPreview ()
    {
        $response = (string) $this->getXMLFileMock('getBannerPreviewResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getBannerPreview', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getBannerPreview($id)
        );
    }
    
    public function testGetBanner ()
    {
        $response = (string) $this->getXMLFileMock('getBannerResponse.xml');

        $id = 'test';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getBanner', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getBanner($id)
        );
    }
    
    public function testGetBannersByField ()
    {
        $response = (array) $this->getXMLFileMock('getBannersByFieldResponse.xml');

        $field = 'test';
    	$value = 'test';
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
            ->with('getBannersByField', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getBannersByField(
        		$field,
        		$value,
        		$limit
            )
        );
    }
    
    public function testGetBannersByFieldWrongLimit ()
    {
        $field = 'test';
        $value = 'test';
        $limit = 5000;

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('getBannersByField')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $service->getBannersByField(
        		$field,
        		$value,
        		$limit
            );
    }
    
    public function testGetBannersByPeriod ()
    {
        $response = (array) $this->getXMLFileMock('getBannersByPeriodResponse.xml');

        $dateStart = 1;
	    $dateEnd = 5;
	
        $parameters = [
            'dateBegin' => date('Y-m-d H:i:s', (int) $dateStart),
            'dateEnd' => date('Y-m-d H:i:s', (int) $dateEnd)
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getBannersByPeriod', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getBannersByPeriod(
        		$dateStart,
        		$dateEnd
            )
        );
    }
    
    public function testGetLastBanners ()
    {
        $response = (array) $this->getXMLFileMock('getLastBannersResponse.xml');

        $limit = 500;
	
        $parameters = ['limit' => (int) $limit];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getLastBanners', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getLastBanners($limit)
        );
    }
    
    public function testGetLastBannersWrongLimit ()
    {
        $limit = 5000;

        $this->setExpectedException('\Exception');

        $this->clientFactory
                ->expects($this->any())
                ->method('getLastBanners')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $service->getLastBanners($limit);
    }
    
    public function testTrackAllBannerLinks ()
    {
        $response = (int) $this->getXMLFileMock('trackAllBannerLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('trackAllBannerLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->trackAllBannerLinks($id)
        );
    }
    
    public function testUntrackAllBannerLinks ()
    {
        $response = (int) $this->getXMLFileMock('untrackAllBannerLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('untrackAllBannerLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->untrackAllBannerLinks($id)
        );
    }
    
    public function testTrackBannerLinkByPosition ()
    {
        $response = (int) $this->getXMLFileMock('trackBannerLinkByPositionResponse.xml');

        $id = 'test';
	    $position = 'test';
	
        $parameters = [
            'id' => (string) $id,
            'position' => (int) $position
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('trackBannerLinkByPosition', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->trackBannerLinkByPosition($id, $position)
        );
    }
    
    public function testUntrackBannerLinkByOrder ()
    {
        $response = (bool) $this->getXMLFileMock('untrackBannerLinkByOrderResponse.xml');

        $id = '1';
	    $order = 'test';
	
        $parameters = [
            'id' => (string) $id,
            'order' => (int) $order
        ];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('untrackBannerLinkByOrder', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->untrackBannerLinkByOrder($id, $order)
        );
    }
    
    public function testGetAllBannerTrackedLinks ()
    {
        $response = (array) $this->getXMLFileMock('getAllBannerTrackedLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getAllBannerTrackedLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getAllBannerTrackedLinks($id)
        );
    }
    
    public function testGetAllUnusedBannerTrackedLinks ()
    {
        $response = (array) $this->getXMLFileMock('getAllUnusedBannerTrackedLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getAllUnusedBannerTrackedLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getAllUnusedBannerTrackedLinks($id)
        );
    }
    
    public function testGetAllBannerTrackableLinks ()
    {
        $response = (array) $this->getXMLFileMock('getAllBannerTrackableLinksResponse.xml');

        $id = '1';
	
        $parameters = ['id' => (string) $id];

        $apiClient = $this->getMockBuilder('\MyLittle\CampaignCommander\API\SOAP\APIClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $apiClient
            ->expects($this->once())
            ->method('doCall')
            ->with('getAllBannerTrackableLinks', $parameters)
            ->will($this->returnValue($response))
        ;

        $this->clientFactory
                ->expects($this->any())
                ->method('createClient')
                ->will($this->returnValue($apiClient))
        ;

        $service = new CcmdDynamicContentService($this->clientFactory);

        $this->assertEquals(
            $response,
            $service->getAllBannerTrackableLinks($id)
        );
    }   
}