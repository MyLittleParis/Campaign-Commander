<?php

namespace MyLittle\CampaignCommander\API\SOAP;


use MyLittle\CampaignCommander\API\SOAP\Model\SoapClientFactoryInterface;

/**
 * StandartSoapClientFactory
 *
 * @author mylittleparis
 */
class StandardSoapClientFactory implements SoapClientFactoryInterface
{
    /**
     * @var SoapClientBuilder
     */
    protected $builder;

    /**
     * Constructor
     *
     * @param \BeSimple\SoapClient\SoapClientBuilder $builder
     * @param type $wsdl
     */
    public function __construct(SoapClientBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Create the soap client
     *
     * @param string $wsdl Description
     *
     * @return \BeSimple\SoapClient\SoapClient
     */
    public function createClient($wsdl)
    {
        $this->builder
            ->withEncoding('UTF-8')
            ->withSingleElementArrays()
            ->withUserAgent('PHP/SOAP CampaignCommander')
            ->withSoapVersion11()
            ->withTrace()
            ->withExceptions()
            ->withWsdlCacheNone()
            ->withWsdl($wsdl)
        ;

        return $this->builder->build();
    }
}
