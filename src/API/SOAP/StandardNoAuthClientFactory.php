<?php

namespace MyLittle\CampaignCommander\API\SOAP;

use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use BeSimple\SoapClient\SoapClientBuilder;

/**
 * Class StandardClientFactory
 *
 * @package  MyLittle\CampaignCommander\API\SOAP
 * @author   Olivier Beauchemin <obeauchemin@crakmedia.com>
 */
class StandardNoAuthClientFactory implements ClientFactoryInterface
{
    /**
     * @var SoapClientBuilder
     */
    protected $builder;

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
     * @param string $server
     */
    public function __construct(SoapClientBuilder $builder, $server)
    {
        $this->builder = $builder;
        $this->server = $server;
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
            ->withWsdl($this->server . '/' . $wsdl)
            ->build()
        ;

        return new APIClient(
            $soapClient,
            null,
            null,
            null
        );
    }
}
