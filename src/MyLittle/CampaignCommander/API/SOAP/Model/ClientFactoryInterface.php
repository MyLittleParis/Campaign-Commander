<?php

namespace MyLittle\CampaignCommander\API\SOAP\Model;

/**
 * SoapClientFactoryInterface
 * @author mylittleparis
 */
interface ClientFactoryInterface
{
    /**
     * Create the soap client
     *
     * @return \MyLittle\CampaignCommander\API\SOAP\APIClient
     */
    public function createClient($wsdl);
}
