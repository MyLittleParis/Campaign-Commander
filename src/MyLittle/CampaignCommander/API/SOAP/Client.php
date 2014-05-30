<?php

/**
 * This source file can be used to communicate with Campaign Commander (http://campaigncommander.com)
 *
 * The class is documented in the file itself. If you find any bugs help me out
 * and report them. Reporting can be done by sending an email to
 * php-campaign-commander-member-bugs[at]verkoyen[dot]eu.
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
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation and/or
 * other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products derived
 * from this software without specific prior written permission.
 *
 * This software is provided by the author "as is" and any express or implied
 * warranties, including, but not limited to, the implied warranties of
 * merchantability and fitness for a particular purpose are disclaimed. In no event
 * shall the author be liable for any direct, indirect, incidental, special,
 * exemplary, or consequential damages (including, but not limited to, procurement
 * of substitute goods or services; loss of use, data, or profits; or business
 * interruption) however caused and on any theory of liability, whether in contract,
 * strict liability, or tort (including negligence or otherwise) arising in any way
 * out of the use of this software, even if advised of the possibility of such damage.
 *
 * @version         1.1.2
 * @copyright       Copyright (c), Tijs Verkoyen. All rights reserved.
 * @license         BSD License
 */

namespace MyLittle\CampaignCommander\API\SOAP;

use MyLittle\CampaignCommander\Client\Model\ClientInterface;
use MyLittle\CampaignCommander\Exception\CampaignCommanderException;

/**
 * Abstract client class
 *
 * @author Tijs     Verkoyen <php-campaign-commander-member@verkoyen.eu>
 * @author Jocelyn Kerbourc'h <jocelyn@mylittleparis.com>
 */
class Client implements ClientInterface
{
    // internal constant to enable/disable debugging
    const DEBUG = false;

    // current version
    const VERSION = '1.2';

    /**
     * The API-key that will be used for authenticating
     *
     * @var string
     */
    protected $key;

    /**
     * The login that will be used for authenticating
     *
     * @var string
     */
    protected $login;

    /**
     * The password that will be used for authenticating
     *
     * @var string
     */
    protected $password;

    /**
     * The type of API
     *
     * @var string
     */
    protected $api;

    /**
     * The server to use
     *
     * @var string
     */
    protected $server = 'http://emvapi.emv3.com';

    /**
     * Url api
     *
     * @var string
     */
    protected $wsdl;

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
    protected $token = null;

    /**
     * The timeout
     *
     * @var int
     */
    protected $timeOut = 60;

    /**
     * The user agent
     *
     * @var string
     */
    protected $userAgent;

    /**
     * Default constructor
     *
     * @param  string           $login    Login provided for API access.
     * @param  string           $password The password.
     * @param  string           $key      Manager Key copied from the CCMD web application.
     * @param  string           $wsdl     the wsdl link for api
     * @param  string[optional] $server   The server to use. Ask your account-manager.
     */
    public function __construct($login, $password, $key, $wsdl = self::WSDL_URL_CCMD, $server = null)
    {
        $this->login = $login;
        $this->password =$password;
        $this->key= $key;
        $this->wsdl = $wsdl;

        if($server !== null) {
            $this->server = $server;
        }
    }

    /**
     * Destructor
     *
     * if the connection is open then
     *  close it and reset variables.
     */
    public function __destruct()
    {
        if ($this->soapClient !== null) {
            if (!$this->closeApiConnection()) {
                $this->soapClient = null;
                $this->token = null;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function closeApiConnection()
    {
        // make the call
        $response = $this->doCall('closeApiConnection');

        // validate response
        if ($response == 'connection closed') {
            // reset vars
            $this->soapClient = null;
            $this->token = null;

            return true;
        }

        // fallback
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function openApiConnection()
    {
        $options = [
            'soap_version' => SOAP_1_1,
            'trace' => self::DEBUG,
            'exceptions' => true,
            'connection_timeout' => $this->timeOut,
            'user_agent' => $this->userAgent,
            'typemap' => [
                'type_ns' => 'http://www.w3.org/2001/XMLSchema',
                'type_name' => 'long',
                'to_xml' => [__CLASS__, 'toLongXML'],
                'from_xml' => [__CLASS__, 'fromLongXML']
                ] // map long to string, because a long can cause an integer overflow
        ];

        $wsdl = $this->server . '/' . $this->wsdl;
        $this->soapClient = new \SoapClient($wsdl, $options);

        $loginParameters['login'] = $this->getLogin();
        $loginParameters['pwd'] = $this->getPassword();
        $loginParameters['key'] = $this->getKey();

        $response = $this->soapClient->openApiConnection($loginParameters);

        // validate
        if (is_soap_fault($response)) {
            $message = 'Internal Error';

            // more detailed message available
            if(isset($response->detail->ConnectionServiceException->description)) {
                $message = (string) $response->detail->ConnectionServiceException->description;
            }

            // invalid token
            if ($message == 'Please enter a valid token to validate your connection.') {
                $this->token = null;
            }

            throw new CampaignCommanderException($message);
        }

        // if response is not valid
        if(!isset($response->return)) {
            throw new CampaignCommanderException('Invalid response');
        }
        $this->token = (string) $response->return;
    }

    /**
     * {@inheritDoc}
     */
    protected function doCall($method, array $parameters)
    {
        // open connection if needed
        if ($this->soapClient === null || $this->token === null) {
            $this->openApiConnection();
        }

        // parameters strings should be UTF8
        foreach ($parameters as $key => $value) {
            if (gettype($value) == 'string' && mb_detect_encoding($value)!="UTF-8") {
                $parameters[$key] = utf8_encode($value);
            }
        }

        $parameters['token'] = $this->token;

        try {
            $response = $this->soapClient->__soapCall($method, array($parameters));
        } catch (Exception $e) {
            $message = $e->getMessage();

            throw new CampaignCommanderException($message);
        }

        // validate response
        if (is_soap_fault($response)) {
            $message = 'Internal Error';

            if(isset($response->detail->ConnectionServiceException->description)) {
                $message = (string) $response->detail->ConnectionServiceException->description;
            }

            if(isset($response->detail->MemberServiceException->description)) {
                $message = (string) $response->detail->MemberServiceException->description;
            }

            if (isset($response->detail->CcmdServiceException->description)) {
                $message = (string) $response->detail->CcmdServiceException->description;
                if(isset($response->detail->CcmdServiceException->fields)) {
                    $message .= ' fields: ' . $response->detail->CcmdServiceException->fields;
                }
                if(isset($response->detail->CcmdServiceException->status)) {
                    $message .= ' status: ' . $response->detail->CcmdServiceException->status;
                }
            }

            throw new CampaignCommanderException($message);
        }

        if(!isset($response->return)) {
            return null;
        }

        return $response->return;
    }

    /**
     * Convert a long into a string
     *
     * @param string $value	The value to convert.
     *
     * @return string
     */
    protected static function fromLongXML($value)
    {
        return (string) strip_tags($value);
    }

    /**
     * Convert a variable into a long
     *
     * @param string $value	The value to convert.
     *
     * @return string
     */
    protected static function toLongXML($value)
    {
        return '<long>' . $value . '</long>';
    }

    /**
     * {@inheritDoc}
     */
    public function getUserAgent()
    {
        return (string) 'PHP Campaign Commander/' . self::VERSION . ' ' . $this->userAgent;
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

        return $this;
    }

    /**
     * Set the server that has to be used.
     *
     * @param string $server
     */
    public function setServer($server)
    {
        $this->server = (string) $server;

        return $this;
    }

    /**
     * Set the wsdl url
     *
     * @param string $wsdl
     */
    public function setWsdl($wsdl)
    {
        $this->wsdl = $wsdl;

        return $this;
    }
}