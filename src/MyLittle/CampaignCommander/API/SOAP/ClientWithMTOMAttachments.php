<?php

namespace MyLittle\CampaignCommander\API\SOAP;

use BeSimple\SoapClient;
use BeSimple\SoapCommon\Helper;

/**
 * Client with mtom attachments
 *
 * @author mylittleparis
 */
class ClientWithMTOMAttachments extends Client
{
    /**
     * Build the soap client
     *
     * @override
     */
    protected function buildSoapClient()
    {
        $builder = SoapClient\SoapClientBuilder::createWithDefaults();
        $builder
                ->withWsdlCacheNone()
                ->withTrace()
                ->withExceptions()
                ->withSoapVersion11()
                ->withWsdl($this->wsdl)
                ->withMtomAttachments()
        ;

        $this->soapClient = $builder->build();

        $kernel = $this->soapClient->getSoapKernel();
        $mimeFilter = new SoapClient\Mimefilter(Helper::ATTACHMENTS_TYPE_MTOM);
        $kernel->registerFilter($mimeFilter);
    }
}
