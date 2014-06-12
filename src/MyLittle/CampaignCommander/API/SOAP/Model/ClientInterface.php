<?php

namespace MyLittle\CampaignCommander\API\SOAP\Model;

/**
 * Client interface
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
     * Open the connection
     */
    public function openApiConnection();

    /**
     * Close the connection
     *
     * @return bool if the connection was closes, otherwise false.
     */
    public function closeApiConnection();

    /**
     * Make the call
     *
     * @param string          $method       The method to be called.
     * @param array[optional] $parameters   The parameters.
     *
     * @return mixed
     */
    public function doCall($method, array $parameters = []);

    /**
     * Get the useragent that will be used. Our version will be prepended to yours.
     * It will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
     *
     * @return string
     */
    public function getUserAgent();

    /**
     * Set the user-agent for you application
     * It will be appended to ours, the result will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
     *
     * @param string $userAgent	The user-agent, it should look like <app-name>/<app-version>.
     */
    public function setUserAgent($userAgent);

    /**
     * Set the wsdl url
     *
     * @param string $wsdl
     */
    public function setWsdl($wsdl);
}
