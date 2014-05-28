<?php

namespace MyLittle\CampaignCommander\Tests;

use MyLittle\CampaignCommander\Member;

/**
 * CampaignCommanderMember test case.
 */
class CampaignCommanderMemberTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var CampaignCommanderMember
	 */
	private $campaignCommanderMember;


	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->campaignCommanderMember = new Member(LOGIN, PASSWORD, KEY);
	}


	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->campaignCommanderMember = null;

		parent::tearDown();
	}


	/**
	 * Tests CampaignCommanderMember->getTimeOut()
	 */
	public function testGetTimeOut()
	{
		$this->campaignCommanderMember->setTimeOut(5);
		$this->assertEquals(5, $this->campaignCommanderMember->getTimeOut());
	}


	/**
	 * Tests CampaignCommanderMember->getUserAgent()
	 */
	public function testGetUserAgent()
	{
		$this->campaignCommanderMember->setUserAgent('testing/1.0.0');
		$this->assertEquals('PHP Campaign Commander Member/' . Member::VERSION . ' testing/1.0.0', $this->campaignCommanderMember->getUserAgent());
	}


	/**
	 * Tests CampaignCommanderMember->descMemberTable()
	 */
	public function testDescMemberTable()
	{
		$this->assertInternalType('array', $this->campaignCommanderMember->descMemberTable());
	}


	/**
	 * Tests CampaignCommanderMember->getMemberByEmail()
	 */
	public function testGetMemberByEmail()
	{
		$var = $this->campaignCommanderMember->getMemberByEmail('spam@verkoyen.eu');

		$this->assertArrayHasKey('EMVDOUBLON', $var);
		$this->assertArrayHasKey('EMAIL', $var);
		$this->assertArrayHasKey('DATEUNJOIN', $var);
		$this->assertArrayHasKey('MEMBER_ID', $var);
		$this->assertArrayHasKey('DATEJOIN', $var);
	}


	/**
	 * Tests CampaignCommanderMember->getMemberById()
	 */
	public function testGetMemberById()
	{
		$var = $this->campaignCommanderMember->getMemberById('1048473894275');

		$this->assertArrayHasKey('EMVDOUBLON', $var);
		$this->assertArrayHasKey('EMAIL', $var);
		$this->assertArrayHasKey('DATEUNJOIN', $var);
		$this->assertArrayHasKey('MEMBER_ID', $var);
		$this->assertArrayHasKey('DATEJOIN', $var);
	}


	/**
	 * Tests CampaignCommanderMember->getListMembersByObj()
	 */
	public function testGetListMembersByObj()
	{
		$this->assertInternalType('array', $this->campaignCommanderMember->getListMembersByObj(array('dynContent' => array(), 'memberUID' => 'FIRSTNAME:jan')));
	}


	/**
	 * Tests CampaignCommanderMember->getListMembersByPage()
	 */
	public function testGetListMembersByPage()
	{
		$this->assertInternalType('array', $this->campaignCommanderMember->getListMembersByPage(1));
	}


	/**
	 * Tests CampaignCommanderMember->insertMember()
	 */
	public function testInsertMember()
	{
		$this->assertInternalType('string', $this->campaignCommanderMember->insertMember('spam@verkoyen.eu'));
	}


	/**
	 * Tests CampaignCommanderMember->updateMember()
	 */
	public function testUpdateMember()
	{
		$this->assertInternalType('string', $this->campaignCommanderMember->updateMember('spam@verkoyen.eu', 'FIRSTNAME', 'spam'));
	}


	/**
	 * Tests CampaignCommanderMember->insertOrUpdateMemberByObj()
	 */
	public function testInsertOrUpdateMemberByObj()
	{
		$this->assertInternalType('string', $this->campaignCommanderMember->insertOrUpdateMemberByObj(array('FIRSTNAME' => 'MARK'), 'spam@verkoyen.eu'));
	}


	/**
	 * Tests CampaignCommanderMember->updateMemberByObj()
	 */
	public function testUpdateMemberByObj()
	{
		$this->assertInternalType('string', $this->campaignCommanderMember->updateMemberByObj(array('FIRSTNAME' => 'MARK'), 'spam@verkoyen.eu'));
	}


	/**
	 * Tests CampaignCommanderMember->getMemberJobStatus()
	 */
	public function testGetMemberJobStatus()
	{
		$var = $this->campaignCommanderMember->updateMember('spam@verkoyen.eu', 'FIRSTNAME', time());
		$var = $this->campaignCommanderMember->getMemberJobStatus($var);
		$this->assertInternalType('string', $var);
		$this->assertEquals('Insert', $var);
	}


	/**
	 * Tests CampaignCommanderMember->unjoinMemberByEmail()
	 */
	public function testUnjoinMemberByEmail()
	{
		$this->assertInternalType('string', $this->campaignCommanderMember->unjoinMemberByEmail('spam@verkoyen.eu'));
	}


	/**
	 * Tests CampaignCommanderMember->unjoinMemberById()
	 */
	public function testUnjoinMemberById()
	{
		$this->assertInternalType('string', $this->campaignCommanderMember->unjoinMemberById('1048473894275'));
		$this->assertInternalType('string', $this->campaignCommanderMember->rejoinMemberById('1048473894275'));
	}


	/**
	 * Tests CampaignCommanderMember->unjoinMemberByObj()
	 */
	public function testUnjoinMemberByObj()
	{
		$this->assertInternalType('string', $this->campaignCommanderMember->unjoinMemberByObj(array('dynContent' => array(), 'memberUID' => 'email:spam@verkoyen.eu')));
		$this->assertInternalType('string', $this->campaignCommanderMember->rejoinMemberByEmail('spam@verkoyen.eu'));
	}
}

