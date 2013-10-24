<?php

namespace MyLittle\CampaignCommander;

use MyLittle\CampaignCommander\CampaignCommanderNotificationMessagingException;

/**
 * Campaign Commander Notification Messaging class
 *
 * This source file can be used to communicate with Campaign Commander Notification Messaging API (http://campaigncommander.com)
 *
 * The class is documented in the file itself. If you find any bugs help me out and report them. Reporting can be done by sending an email to php-campaign-commander-notificiation-messaging-bugs[at]verkoyen[dot]eu.
 * If you report a bug, make sure you give me enough information (include your code).
 *
 * Changelog since 1.0.0
 * - Bugfix: wrapped dyn fields in CDATA-tags.
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
 * @author          Tijs Verkoyen <php-campaign-commander-notificiation-messaging@verkoyen.eu>
 * @author          Jocelyn Kerbourc'h <jocelyn@mylittleparis.com>
 * @version         1.0.1
 *
 * @copyright       Copyright (c), Tijs Verkoyen. All rights reserved.
 * @license         BSD License
 */
class Notification
{
	// internal constant to enable/disable debugging
	const DEBUG = false;

	// url for the api
	const API_URL = 'http://api.notificationmessaging.com/NMSXML';

	// port for the api
	const API_PORT = 80;

	// current version
	const VERSION = '1.0.1';


	/**
	 * A cURL instance
	 *
	 * @var	resource
	 */
	private $curl;


	/**
	 * The request queue
	 *
	 * @var	array
	 */
	private $queue = array();


	/**
	 * The timeout
	 *
	 * @var	int
	 */
	private $timeOut = 60;


	/**
	 * The user agent
	 *
	 * @var	string
	 */
	private $userAgent;

	/**
	 * Make the call
	 *
	 * @return	string
	 * @param	string $xmlBody		The XML to send.
	 */
	private function doCall($xmlBody)
	{
		// no body
		if($xmlBody == '') return null;

		// build XML
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$xml .= '<MultiSendRequest>' . "\n";

		// add body
		$xml .= (string) $xmlBody;

		// end XML
		$xml .= '</MultiSendRequest>';

		// set options
		$options[CURLOPT_URL] = self::API_URL;
		$options[CURLOPT_PORT] = self::API_PORT;
		$options[CURLOPT_USERAGENT] = $this->getUserAgent();
		$options[CURLOPT_FOLLOWLOCATION] = true;
		$options[CURLOPT_RETURNTRANSFER] = true;
		$options[CURLOPT_TIMEOUT] = (int) $this->getTimeOut();
		$options[CURLOPT_POST] = 1;
		$options[CURLOPT_POSTFIELDS] = $xml;

		// init
		if($this->curl == null) $this->curl = curl_init();

		// set options
		curl_setopt_array($this->curl, $options);

		// execute
		$response = curl_exec($this->curl);
		$headers = curl_getinfo($this->curl);

		// fetch errors
		$errorNumber = curl_errno($this->curl);
		$errorMessage = curl_error($this->curl);

		// replace wierd stuff
		$response = str_replace('ns1:', 'ns1_', $response);

		// we expect XML, so decode it
		$responseXML = @simplexml_load_string($response);

		// validate
		if($responseXML === false) throw new CampaignCommanderNotificationMessagingException('Invalid body.');

		// status?
		if((string) $responseXML->element['responseStatus'] == 'failed')
		{
			$message = '';

			// add all errors
			foreach($responseXML->element as $element) $message .= 'Failed for ' . $element['email'] . ': ' . (string) $element->result . "<br />\n";

			// throw exception
			throw new CampaignCommanderNotificationMessagingException($message);
		}

		// other error?
		if(isset($responseXML->ns1_faultstring))
		{
			if(self::DEBUG)
			{
				echo '<pre>';
				var_dump($xml);
				echo '--';
				var_dump($response);
				echo '</pre>';
			}

			throw new CampaignCommanderNotificationMessagingException((string) $responseXML->ns1_faultstring);
		}

		// return
		return $responseXML;
	}


	/**
	 * Get the timeout that will be used
	 *
	 * @return	int
	 */
	public function getTimeOut()
	{
		return (int) $this->timeOut;
	}


	/**
	 * Get the useragent that will be used. Our version will be prepended to yours.
	 * It will look like: "PHP Campaing Commander/<version> <your-user-agent>"
	 *
	 * @return	string
	 */
	public function getUserAgent()
	{
		return (string) 'PHP Campaing Commander Notification Messaging/' . self::VERSION . ' ' . $this->userAgent;
	}


	/**
	 * Set the timeout
	 * After this time the request will stop. You should handle any errors triggered by this.
	 *
	 * @return	void
	 * @param	int $seconds	The timeout in seconds.
	 */
	public function setTimeOut($seconds)
	{
		$this->timeOut = (int) $seconds;
	}


	/**
	 * Set the user-agent for you application
	 * It will be appended to ours, the result will look like: "PHP Campaign Commander Notifiction Messaging/<version> <your-user-agent>"
	 *
	 * @return	void
	 * @param	string $userAgent	Your user-agent, it should look like <app-name>/<app-version>.
	 */
	public function setUserAgent($userAgent)
	{
		$this->userAgent = (string) $userAgent;
	}


	/**
	 * Add a request to the queue
	 *
	 * @return	int								The id in the queue.
	 * @param	string $uniqueIdentifier		The unique identifier for the template to use.
	 * @param	string $securityTag				The security tag for the template to use.
	 * @param	string $email					The recipient's email address to which you want to send the message.
	 * @param	array[optional] $dyn			Dynamic fields.
	 * @param	array[optional] $content		Portion of preformated HTML or textblocks.
	 * @param	string[optional] $type			The action you want to execute on this member to synchronise with your Marketing CCMD Account (“MEMBER” table). Four synchronization options events are available: INSERT, UPDATE, INSERT_UPDATE, NOTHING.
	 * @param	int[optional] $sendDate			The date when the message has to be sent.
	 * @param	string[optional] $uidKey		The name of the column used to match with the MEMBER table. It will match the DYN parameters that has the same name to retrieve the associated value.
	 */
	public function addRequestToQueue($uniqueIdentifier, $securityTag, $email, array $dyn = null, array $content = null, $type = 'INSERT_UPDATE', $sendDate = null, $uidKey = 'email')
	{
		// init var
		$allowedTypes = array('INSERT', 'UPDATE', 'INSERT_UPDATE', 'NOTHING');

		// redefine
		$uniqueIdentifier = utf8_encode((string) $uniqueIdentifier);
		$securityTag = utf8_encode((string) $securityTag);
		$email = utf8_encode((string) $email);
		$type = utf8_encode((string) $type);
		$sendDate = ($sendDate !== null) ? (int) $sendDate : (time() - 24 * 60 * 60);
		$uidKey = utf8_encode((string) $uidKey);

		// validate type
		if(!in_array($type, $allowedTypes)) throw new CampaignCommanderNotificationMessagingException('Invalid type(' . $type . '), possible values are: ' . implode($allowedTypes));

		// build XML
		$xml = '<sendrequest>' . "\n";

		// dynamic fields?
		if($dyn !== null)
		{
			// start
			$xml .= '	<dyn>' . "\n";

			// loop pairs
			foreach($dyn as $key => $value) $xml .= '		<entry><key>' . $key . '</key><value>' . utf8_encode($value) . '</value></entry>' . "\n";

			// end
			$xml .= '	</dyn>' . "\n";
		}

		// content fields?
		if($content !== null)
		{
			// start
			$xml .='	<content>' . "\n";

			// loop pairs
			foreach($content as $key => $value) $xml .= '		<entry><key>' . $key . '</key><value><![CDATA[' . utf8_encode($value) . ']]></value></entry>' . "\n";

			// end
			$xml .='	</content>' . "\n";
		}

		$xml .= '	<email>' . $email . '</email>' . "\n";
		$xml .= '	<encrypt>' . $securityTag . '</encrypt>' . "\n";
		$xml .= '	<random>' . $uniqueIdentifier . '</random>' . "\n";
		$xml .= '	<senddate>' . date('Y-m-d\TH:i:s', $sendDate) . '</senddate>' . "\n";
		$xml .= '	<synchrotype>' . $type . '</synchrotype>' . "\n";
		$xml .= '	<uidkey>' . $uidKey . '</uidkey>' . "\n";

		// end XML
		$xml .= '</sendrequest>';

		// create new id
		$id = count($this->queue);

		// add to queue
		$this->queue[$id] = $xml;

		// return the id
		return $id;
	}


	/**
	 * Make a request
	 *
	 * @return	void
	 * @param	string $uniqueIdentifier		The unique identifier for the template to use.
	 * @param	string $securityTag				The security tag for the template to use.
	 * @param	string $email					The recipient's email address to which you want to send the message.
	 * @param	array[optional] $dyn			Dynamic fields.
	 * @param	array[optional] $content		Portion of preformated HTML or textblocks.
	 * @param	string[optional] $type			The action you want to execute on this member to synchronise with your Marketing CCMD Account (“MEMBER” table). Four synchronization options events are available: INSERT, UPDATE, INSERT_UPDATE, NOTHING.
	 * @param	int[optional] $sendDate			The date when the message has to be sent.
	 * @param	string[optional] $uidKey		The name of the column used to match with the MEMBER table. It will match the DYN parameters that has the same name to retrieve the associated value.
	 */
	public function makeRequest($uniqueIdentifier, $securityTag, $email, array $dyn = null, array $content = null, $type = 'INSERT_UPDATE', $sendDate = null, $uidKey = 'email')
	{
		// init var
		$allowedTypes = array('INSERT', 'UPDATE', 'INSERT_UPDATE', 'NOTHING');

		// redefine
		$uniqueIdentifier = (string) $uniqueIdentifier;
		$securityTag = (string) $securityTag;
		$email = (string) $email;
		$type = (string) $type;
		$sendDate = ($sendDate !== null) ? (int) $sendDate : time();
		$uidKey = (string) $uidKey;

		// validate type
		if(!in_array($type, $allowedTypes)) throw new CampaignCommanderNotificationMessagingException('Invalid type(' . $type . '), possible values are: ' . implode($allowedTypes));

		// build XML
		$xml = '<sendrequest>' . "\n";

		// dynamic fields?
		if($dyn !== null)
		{
			// start
			$xml .= '	<dyn>' . "\n";

			// loop pairs
			foreach($dyn as $key => $value) $xml .= '		<entry><key>' . $key . '</key><value><![CDATA[' . utf8_encode($value) . ']]></value></entry>' . "\n";

			// end
			$xml .= '	</dyn>' . "\n";
		}

		// content fields?
		if($content !== null)
		{
			// start
			$xml .='	<content>' . "\n";

			// loop pairs
			foreach($content as $key => $value) $xml .= '		<entry><key>' . $key . '</key><value><![CDATA[' . utf8_encode($value) . ']]></value></entry>' . "\n";

			// end
			$xml .='	</content>' . "\n";
		}

		$xml .= '	<email>' . $email . '</email>' . "\n";
		$xml .= '	<encrypt>' . $securityTag . '</encrypt>' . "\n";
		$xml .= '	<random>' . $uniqueIdentifier . '</random>' . "\n";
		$xml .= '	<senddate>' . date('c', $sendDate) . '</senddate>' . "\n";
		$xml .= '	<synchrotype>' . $type . '</synchrotype>' . "\n";
		$xml .= '	<uidkey>' . $uidKey . '</uidkey>' . "\n";

		// end XML
		$xml .= '</sendrequest>';

		// make the call
		$this->doCall($xml);
	}


	/**
	 * Process the queue
	 *
	 * @return	void
	 */
	public function processQueue()
	{
		// anything queued?
		if(!empty($this->queue))
		{
			// init var
			$xml = implode("\n", $this->queue);

			// make the call
			$response = $this->doCall($xml);

			// clear queue
			$this->queue = array();
		}
	}
}
