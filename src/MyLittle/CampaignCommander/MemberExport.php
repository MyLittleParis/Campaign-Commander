<?php

namespace MyLittle\CampaignCommander;

use MyLittle\CampaignCommander\Exception\CampaignCommanderMemberException;

/**
 * Campaign Commander Member Export class
 *
 * This source file can be used to communicate with Campaign Commander (http://campaigncommander.com)
 *
 * The class is documented in the file itself. If you find any bugs help me out and report them. Reporting can be done by sending an email to php-campaign-commander-member-bugs[at]verkoyen[dot]eu.
 * If you report a bug, make sure you give me enough information (include your code).
 *
 * Changelog since 1.1.2
 * - made the setServer-method public
 *
 * Changelog since 1.1.1
 * - Applied new coding standards.
 *
 * Changelog since 1.1.0
 * - Better handling for errormessages.
 *
 * Changelog since 1.0.2
 * - Added method to set the server.
 * - Renamed methods to reflect to current API
 *
 * Changelog since 1.0.1
 * - Typemapping for really long longs.
 * - No more casting to integers (because of the really long longs).
 *
 * Changelog since 1.0.0
 * - debug is off by default.
 * - wrapped the close-call in a try-catch block in the destructor.
 *
 * License
 * Copyright (c), Tijs Verkoyen. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products derived from this software without specific prior written permission.
 *
 * This software is provided by the author "as is" and any express or implied warranties, including, but not limited to, the implied warranties of merchantability and fitness for a particular purpose are disclaimed. In no event shall the author be liable for any direct, indirect, incidental, special, exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) arising in any way out of the use of this software, even if advised of the possibility of such damage.
 *
 * @author Tijs     Verkoyen <php-campaign-commander-member@verkoyen.eu>
 * @author          Jocelyn Kerbourc'h <jocelyn@mylittleparis.com>
 * @author          Mathieu Ferment <mathieu.ferment@mylittleparis.com>
 * @version         1.1.2
 * @copyright       Copyright (c), Tijs Verkoyen. All rights reserved.
 * @license         BSD License
 */
class MemberExport
{
	// internal constant to enable/disable debugging
	const DEBUG = true;

	// url for the api
	const WSDL_URL = 'apiexport/services/ExportService?wsdl';

	// current version
	const VERSION = '1.0';

	/**
	 * The API-key that will be used for authenticating
	 *
	 * @var string
	 */
	private $key;

	/**
	 * The login that will be used for authenticating
	 *
	 * @var string
	 */
	private $login;

	/**
	 * The password that will be used for authenticating
	 *
	 * @var string
	 */
	private $password;

	/**
	 * The server to use
	 *
	 * @var string
	 */
	private $server = 'http://emvapi.emv3.com';

	/**
	 * The SOAP-client
	 *
	 * @var SoapClient
	 */
	protected $soapClient;

	/**
	 * The token
	 *
	 * @var string
	 */
	private $token = null;

	/**
	 * The timeout
	 *
	 * @var int
	 */
	private $timeOut = 60;

	/**
	 * The user agent
	 *
	 * @var string
	 */
	private $userAgent;

	// class methods
	/**
	 * Default constructor
	 *
	 * @param string $login					The login needed for API access.
	 * @param string $password				The login needed password.
	 * @param string $key					API-Key, can be copied from the CCMD web application.
	 * @param string[optional] $server		The server to use. Ask your account-manager.
	 */
	public function __construct($login, $password, $key, $server = null)
	{
		$this->setLogin($login);
		$this->setPassword($password);
		$this->setKey($key);
		if($server !== null) $this->setServer($server);
	}

	/**
	 * Destructor
	 */
	public function __destruct()
	{
		// is the connection open?
		if($this->soapClient !== null)
		{
			try
			{
				// close
				$this->closeApiConnection();
			}

			// catch exceptions
			catch(Exception $e)
			{
				// do nothing
			}

			// reset vars
			$this->soapClient = null;
			$this->token = null;
		}
	}

	/**
	 * Make the call
	 *
	 * @return mixed
	 * @param string $method				The method to be called.
	 * @param array[optional] $parameters	The parameters.
	 */
	protected function doCall($method, array $parameters = array())
	{
		// open connection if needed
		if($this->soapClient === null || $this->token === null)
		{
			// build options
			$options = array('soap_version' => SOAP_1_1, 'trace' => self::DEBUG, 'exceptions' => true, 'connection_timeout' => $this->getTimeOut(), 'user_agent' => $this->getUserAgent(), 'typemap' => array(array('type_ns' => 'http://www.w3.org/2001/XMLSchema', 'type_name' => 'long', 'to_xml' => array(__CLASS__, 'toLongXML'), 'from_xml' => array(__CLASS__, 'fromLongXML')))			// map long to string, because a long can cause an integer overflow
			);

			// create client
			$this->soapClient = new \SoapClient($this->getServer() . '/' . self::WSDL_URL, $options);

			// build login parameters
			$loginParameters['login'] = $this->getLogin();
			$loginParameters['pwd'] = $this->getPassword();
			$loginParameters['key'] = $this->getKey();

			// make the call
			$response = $this->soapClient->__soapCall('openApiConnection', array($loginParameters));

			// validate
			if(is_soap_fault($response))
			{
				// more detailed message available
				$message = $response->getMessage();
				if(isset($response->detail->ConnectionServiceException->description)) $message = (string) $response->detail->ConnectionServiceException->description;
				if(isset($response->detail->MemberServiceException->description)) $message = (string) $response->detail->MemberServiceException->description . ' ' . $response->detail->MemberServiceException->fields . ' ' . $response->detail->MemberServiceException->status;

				// invalid token?
				if($message == 'Please enter a valid token to validate your connection.')
				{
					// reset token
					$this->token = null;

					// try again
					return self::doCall($method, $parameters);
				}

				// internal debugging enabled
				if(self::DEBUG)
				{
					echo '<pre>';
					echo 'last request<br />';
					var_dump($this->soapClient->__getLastRequest());
					echo 'response<br />';
					var_dump($response);
					echo '</pre>';
				}

				// throw exception
				throw new CampaignCommanderMemberException($message);
			}

			// validate response
			if(!isset($response->return)) throw new CampaignCommanderMemberException('Invalid response');

			// set token
			$this->token = (string) $response->return;
		}

		// redefine
		$method = (string) $method;
		$parameters = (array) $parameters;

		// loop parameters
		foreach($parameters as $key => $value)
		{
			// strings should be UTF8
			if(gettype($value) == 'string') $parameters[$key] = utf8_encode($value);
		}

		// add token
		$parameters['token'] = $this->token;

		try
		{
			// make the call
			$response = $this->soapClient->__soapCall($method, array($parameters));
		}

		catch(Exception $e)
		{
			// internal debugging enabled
			if(self::DEBUG)
			{
				echo '<pre>';
				echo 'last request<br />';
				var_dump($this->soapClient->__getLastRequest());
				echo 'response<br />';
				var_dump($response);
				echo '</pre>';
			}

			// throw exception
			throw new CampaignCommanderMemberException($e->getMessage());
		}

		// validate response
		if(is_soap_fault($response))
		{
			// more detailed message available
			$message = $response->getMessage();
			if(isset($response->detail->ConnectionServiceException->description)) $message = (string) $response->detail->ConnectionServiceException->description;
			if(isset($response->detail->MemberServiceException->description)) $message = (string) $response->detail->MemberServiceException->description;
			if(isset($response->detail->CcmdServiceException->description))
			{
				$message = (string) $response->detail->CcmdServiceException->description;
				if(isset($response->detail->CcmdServiceException->fields)) $message .= ' fields: ' . $response->detail->CcmdServiceException->fields;
				if(isset($response->detail->CcmdServiceException->status)) $message .= ' status: ' . $response->detail->CcmdServiceException->status;
			}

			// internal debugging enabled
			if(self::DEBUG)
			{
				echo '<pre>';
				var_dump(htmlentities($this->soapClient->__getLastRequest()));
				var_dump($this);
				echo '</pre>';
			}

			// throw exception
			throw new CampaignCommanderMemberException($message);
		}

		// empty reply
		if(!isset($response->return)) return null;

		// return the response
		return $response->return;
	}

	/**
	 * Convert a long into a string
	 *
	 * @return string
	 * @param string $value	The value to convert.
	 */
	public static function fromLongXML($value)
	{
		return (string) strip_tags($value);
	}

	/**
	 * Convert a variable into a long
	 *
	 * @return string
	 * @param string $value	The value to convert.
	 */
	public static function toLongXML($value)
	{
		return '<long>' . $value . '</long>';
	}

	/**
	 * Get the key
	 *
	 * @return string
	 */
	private function getKey()
	{
		return (string) $this->key;
	}

	/**
	 * Get the login
	 *
	 * @return string
	 */
	private function getLogin()
	{
		return (string) $this->login;
	}

	/**
	 * Get the password
	 *
	 * @return string
	 */
	private function getPassword()
	{
		return $this->password;
	}

	/**
	 * Get the server
	 *
	 * @return string
	 */
	private function getServer()
	{
		return $this->server;
	}

	/**
	 * Get the timeout that will be used
	 *
	 * @return int
	 */
	public function getTimeOut()
	{
		return (int) $this->timeOut;
	}

	/**
	 * Get the useragent that will be used. Our version will be prepended to yours.
	 * It will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
	 *
	 * @return string
	 */
	public function getUserAgent()
	{
		return (string) 'PHP Campaign Commander Member/' . self::VERSION . ' ' . $this->userAgent;
	}

	/**
	 * Set the Key that has to be used
	 *
	 * @param string $key
	 */
	private function setKey($key)
	{
		$this->key = (string) $key;
	}

	/**
	 * Set the login that has to be used
	 *
	 * @param string $login
	 */
	private function setLogin($login)
	{
		$this->login = (string) $login;
	}

	/**
	 * Set the password that has to be used
	 *
	 * @param string $password
	 */
	private function setPassword($password)
	{
		$this->password = (string) $password;
	}

	/**
	 * Set the server that has to be used.
	 *
	 * @param string $server
	 */
	public function setServer($server)
	{
		$this->server = (string) $server;
	}

	/**
	 * Set the timeout
	 * After this time the request will stop. You should handle any errors triggered by this.
	 *
	 * @param int $seconds
	 */
	public function setTimeOut($seconds)
	{
		$this->timeOut = (int) $seconds;
	}

	/**
	 * Set the user-agent for you application
	 * It will be appended to ours, the result will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
	 *
	 * @param string $userAgent	The user-agent, it should look like <app-name>/<app-version>.
	 */
	public function setUserAgent($userAgent)
	{
		$this->userAgent = (string) $userAgent;
	}

	// connection methods
	/**
	 * Close the connection
	 *
	 * @return bool if the connection was closes, otherwise false.
	 */
	public function closeApiConnection()
	{
		// make the call
		$response = $this->doCall('closeApiConnection');

		// validate response
		if($response == 'connection closed')
		{
			// reset vars
			$this->soapClient = null;
			$this->token = null;

			return true;
		}

		// fallback
		return false;
	}

	public function createDownloadByMailinglist(
		$segmentID,
		$operationType,
		$fieldSelection,
		$fileFormat,
		$dedupFlag,
		$dedupCriteria,
		$keepFirst)
	{
		$parameters = array(
			'mailinglistId' => (string) $segmentID,
			'operationType' => (string) $operationType,
			'fieldSelection' => (string) $fieldSelection,
			'fileFormat' => (string) $fileFormat,
			'dedupFlag' => (string) $dedupFlag,
			'dedupCriteria' => (string) $dedupCriteria,
			'keepFirst' => (string) $keepFirst
		);

		// make the call
		//this will create a file on the server, its ID is returned
		$response = $this->doCall('createDownloadByMailinglist', $parameters);

		$fileID = (int) $response;
		return $fileID;
	}

	public function getDownloadStatus($fileID)
	{
		$parameters = array(
			'id' => (string) $fileID
		);

		$response = $this->doCall('getDownloadStatus', $parameters);

		$status = $response;
		return $status;
	}

	public function getDownloadFile($fileID)
	{
		$parameters = array(
			'id' => (string) $fileID
		);

		$response = $this->doCall('getDownloadFile', $parameters);

		return $response;
	}
}