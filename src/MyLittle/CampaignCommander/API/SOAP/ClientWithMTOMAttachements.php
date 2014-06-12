<?php

namespace MyLittle\CampaignCommander\API\SOAP;

Use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;
use BeSimple\SoapClient;
use BeSimple\SoapCommon\Helper;

/**
 * BeSimpleSoapClient
 * soap client using BeSimpleSoap Libraries
 *
 * @author mylittleparis
 */
class ClientWithMTOMAttachements implements ClientInterface
{
    // current version
    const VERSION = '1.0';

    /**
     * The API-key that will be used for authenticating
     *
     * @var string
     */
    protected $key;

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
     * The server to use
     *
     * @var string
     */
    protected $server;

    /**
     * Url api
     *
     * @var string
     */
    protected $wsdl;

    /**
     * The SOAP-client
     *
     * @var SoapClient
     */
    protected $soapClient;

    /**
     * The token
     *
     * @var string
     */
    protected $token = null;

    /**
     * The timeout
     *
     * @var int
     */
    protected $timeOut = 60;

    /**
     * The user agent
     *
     * @var string
     */
    protected $userAgent;

    /**
     * Default constructor
     *
     * @param  string   $login    Login provided for API access.
     * @param  string   $password The password.
     * @param  string   $key      Manager Key copied from the CCMD web application.
     */
    public function __construct($login, $password, $key)
    {
        $this->login = $login;
        $this->password =$password;
        $this->key= $key;
    }

    /**
     * Destructor
     *
     * if the connection is open then
     *  close it and reset variables.
     */
    public function __destruct()
    {
        if ($this->soapClient !== null && !$this->closeApiConnection()) {
            $this->soapClient = null;
            $this->token = null;
        }
    }

    /**
     * Build the soap client
     */
    private function buildSoapClient()
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

    /**
     * Open the connection
     */
    public function openApiConnection()
    {
            $this->buildSoapClient();

            $loginParameters['login'] = $this->login();
            $loginParameters['pwd'] = $this->password();
            $loginParameters['key'] = $this->key();

        try {
            $response = $this->soapClient->openApiConnection($loginParameters);
        } catch (\SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $this->token = (string) $response->return;
    }

    /**
     * Close the connection
     *
     * @return bool if the connection was closes, otherwise false.
     */
    public function closeApiConnection()
    {
        $response = $this->doCall('closeApiConnection');

        if ($response == 'connection closed') {
            $this->soapClient = null;
            $this->token = null;

            return true;
        }

        return false;
    }

    /**
     * Make the call
     *
     * @param string          $method       The method to be called.
     * @param array[optional] $parameters   The parameters.
     *
     * @return mixed
     */
    public function doCall($method, array $parameters = [])
    {
        // open connection if needed
        if ($this->soapClient === null || $this->token === null) {
            $this->openApiConnection();
        }

        // parameters strings should be UTF8
        foreach ($parameters as $key => $value) {
            if (gettype($value) == 'string' && mb_detect_encoding($value)!="UTF-8") {
                $parameters[$key] = utf8_encode($value);
            }
        }

        $parameters['token'] = $this->token;

        try {
            $response = $this->soapClient->__soapCall($method, array($parameters));
        } catch (\SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }

        if(!isset($response->return)) {
            return null;
        }

        return $response->return;
    }

    /**
     * Get the useragent that will be used. Our version will be prepended to yours.
     * It will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
     *
     * @return string
     */
    public function getUserAgent()
    {
        return (string) 'PHP Campaign Commander/' . self::VERSION . ' ' . $this->userAgent;
    }

    /**
     * Set the user-agent for you application
     * It will be appended to ours, the result will look like: "PHP Campaign Commander Member/<version> <your-user-agent>"
     *
     * @param string $userAgent	The user-agent, it should look like <app-name>/<app-version>.
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = (string) $userAgent;

        return $this;
    }

    /**
     * Set the server that has to be used.
     *
     * @param string $server
     */
    public function setServer($server)
    {
        $this->server = (string) $server;

        return $this;
    }

    /**
     * Set the wsdl url
     *
     * @param string $wsdl
     */
    public function setWsdl($wsdl)
    {
        $this->wsdl = $wsdl;

        return $this;
    }
}
