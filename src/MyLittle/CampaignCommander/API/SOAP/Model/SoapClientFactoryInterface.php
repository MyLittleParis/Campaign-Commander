<?php

namespace MyLittle\CampaignCommander\API\SOAP\Model;

/**
 * SoapClientFactoryInterface
 * @author mylittleparis
 */
interface SoapClientFactoryInterface
{
    /**
     * Create the soap client
     *
     * @return \BeSimple\SoapClient\SoapClient
     */
    public function createClient($wsdl);
}
