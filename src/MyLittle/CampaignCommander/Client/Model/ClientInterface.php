<?php

namespace MyLittle\CampaignCommander\Client\Model;
/**
 * Client interface
 */
interface ClientInterface
{
    /**
     * Make the call
     *
     * @param string          $method       The method to be called.
     * @param array[optional] $parameters   The parameters.
     *
     * @return mixed
     */
    public function doCall($method, array $parameters = array());

    /**
     * Convert a long into a string
     *
     * @param string $value	The value to convert.
     *
     * @return string
     */
    public static function fromLongXML($value);

    /**
     * Convert a variable into a long
     *
     * @param string $value	The value to convert.
     *
     * @return string
     */
    public static function toLongXML($value);

    /**
     * Set the user-agent for you application
     * It will be appended to ours, the result will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
     *
     * @param string $userAgent	The user-agent, it should look like <app-name>/<app-version>.
     */
    public function setUserAgent($userAgent);

    /**
     * Get the useragent that will be used. Our version will be prepended to yours.
     * It will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
     *
     * @return string
     */
    public function getUserAgent();

    /**
     * Set the server that has to be used.
     *
     * @param string $server
     */
    public function setServer($server);

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
}
