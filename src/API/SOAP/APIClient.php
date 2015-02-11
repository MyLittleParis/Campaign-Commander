<?php

/**
 * This source file can be used to communicate with Campaign Commander (http://campaigncommander.com)
 *
 * The class is documented in the file itself. If you find any bugs help me out
 * and report them. Reporting can be done by sending an email to
 * php-campaign-commander-member-bugs[at]verkoyen[dot]eu.
 * If you report a bug, make sure you give me enough information (include your code).
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
 * @copyright       Copyright (c), Tijs Verkoyen. All rights reserved.
 * @license         BSD License
 */

namespace MyLittle\CampaignCommander\API\SOAP;

use BeSimple\SoapClient\SoapClient;
use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;
use MyLittle\CampaignCommander\Exceptions\WebServiceError;

/**
 * client
 *
 * @author mylittleparis
 */
class APIClient implements ClientInterface
{
    /**
     * The SOAP-client
     *
     * @var BeSimple\SoapClient\SoapClient
     */
    protected $soapClient;

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
     * The API-key that will be used for authenticating
     *
     * @var string
     */
    protected $key;

    /**
     * The server to use
     *
     * @var string
     */
    protected $server;

    /**
     * The token
     *
     * @var string
     */
    protected $token = null;

    /**
     * Default constructor
     *
     * @param SoapClient    $soapClient    BeSimple SoapClient
     * @param string        $login         Login provided for API access.
     * @param string        $password      The password.
     * @param string        $key           Manager Key copied from the CCMD web application.
     * @param string        $server        The server to use. Ask your account-manager.
     */
    public function __construct(SoapClient $soapClient, $login, $password, $key, $server)
    {
        $this->soapClient = $soapClient;
        $this->login      = $login;
        $this->password   = $password;
        $this->key        = $key;
        $this->server     = $server;
    }

    /**
     * {@inheritDoc}
     */
    public function closeApiConnection()
    {
        $response = $this->doCall('closeApiConnection');

        $this->soapClient = null;
        $this->token = null;

        return !empty($response);
    }

    /**
     * {@inheritDoc}
     */
    public function openApiConnection()
    {
        $loginParameters = [
            'login' => $this->login,
            'pwd'   => $this->password,
            'key'   => $this->key,
        ];

        try {
            $response = $this->soapClient->openApiConnection($loginParameters);

            $this->token = (string) $response->return;
        } catch (\SoapFault $fault) {
            throw new WebServiceError('Campaign commander API return an error', 0, $fault);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function doCall($method, array $parameters = [])
    {
        // open connection if needed
        if ($this->soapClient === null || $this->token === null) {
            throw new \LogicException('The Api connection is not open.');
        }

        // parameters strings should be UTF8
        foreach ($parameters as $key => $value) {
            if ('string' === gettype($value) && 'UTF-8' !== mb_detect_encoding($value)) {
                $parameters[$key] = utf8_encode($value);
            }
        }

        $parameters['token'] = $this->token;

        try {
            $response = $this->soapClient->__soapCall($method, array($parameters));

            if (!isset($response->return)) {
                return null;
            }

            return $response->return;
        } catch (\SoapFault $fault) {
            throw new WebServiceError('Campaign commander API return an error', 0, $fault);
        }
    }
}
