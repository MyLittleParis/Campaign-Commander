<?php

namespace MyLittle\CampaignCommander\API\SOAP;

/**
 * Client interface
 *
 * @author mylittleparis
 */
interface ClientInterface
{
    const WSDL_URL_CCMD = 'apiccmd/services/CcmdService?wsdl';
    const WSDL_URL_REPORTING = 'apireporting/services/ReportingService?wsdl';
    const WSDL_URL_MEMBER = 'apimember/services/MemberService?wsdl';
    const WSDL_URL_BATCH_MEMBER = 'apibatchmember/services/BatchMemberService?wsdl';
    const WSDL_URL_EXPORT = 'apiexport/services/ExportService?wsdl';
    const WSDL_URL_NOTIFICATION = 'NMSOAP/NotificationService?wsdl';

    /**
     * Make the call
     *
     * @param string          $method       The method to be called.
     * @param array[optional] $parameters   The parameters.
     *
     * @return mixed
     */
    public function doCall($method, array $parameters = []);
}
