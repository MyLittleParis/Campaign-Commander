<?php

namespace MyLittle\CampaignCommander\API\SOAP;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use BeSimple\SoapClient\SoapClientBuilder;

/**
 * StandartSoapClientFactory
 *
 * @author mylittleparis
 */
class StandardClientFactory implements ClientFactoryInterface
{
    /**
     * @var SoapClientBuilder
     */
    protected $builder;

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
     * Constructor
     *
     * @param \BeSimple\SoapClient\SoapClientBuilder $builder
     * @param string $login
     * @param string $password
     * @param string $key
     * @param string $server
     */
    public function __construct(SoapClientBuilder $builder, $login, $password, $key, $server)
    {
        $this->builder  = $builder;
        $this->login    = $login;
        $this->password = $password;
        $this->key      = $key;
        $this->server   = $server;
    }

    /**
     * Create the client
     *
     * @param string $wsdl
     *
     * @return \MyLittle\CampaignCommander\API\SOAP\APIClient
     */
    public function createClient($wsdl)
    {
        $soapClient = $this->builder
            ->withEncoding('UTF-8')
            ->withSingleElementArrays()
            ->withUserAgent('PHP/SOAP CampaignCommander')
            ->withSoapVersion11()
            ->withTrace()
            ->withExceptions()
            ->withWsdlCacheNone()
            ->withMtomAttachments()
            ->withWsdl($this->server . '/' . $wsdl)
            ->build()
        ;

        return new APIClient(
            $soapClient,
            $this->login,
            $this->password,
            $this->key
        );
    }
}
