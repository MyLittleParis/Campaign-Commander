<?php

namespace MyLittle\CampaignCommander\API\SOAP;

use MyLittle\CampaignCommander\API\SOAP\Model\SoapClientFactoryInterface;
use BeSimple\SoapCommon\Helper;

/**
 * Client with mtom attachments Factory
 *
 * @author mylittleparis
 */
class MTOMAttachmentsSoapClientFactory implements SoapClientFactoryInterface
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
     * @return \BeSimple\SoapClient\SoapClient
     */
    protected function createClient($wsdl)
    {
        $this->builder
            ->withEncoding('UTF-8')
            ->withSingleElementArrays()
            ->withUserAgent('PHP/SOAP MTOM Attachments CampaignCommander')
            ->withWsdlCacheNone()
            ->withTrace()
            ->withExceptions()
            ->withSoapVersion11()
            ->withWsdl($wsdl)
            ->withMtomAttachments()
        ;

        $soapClient = $this->builder->build();

        $kernel = $soapClient->getSoapKernel();
        $mimeFilter = new SoapClient\Mimefilter(Helper::ATTACHMENTS_TYPE_MTOM);
        $kernel->registerFilter($mimeFilter);

        return $soapClient;
    }
}
