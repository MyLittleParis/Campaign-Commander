<?php

namespace MyLittle\CampaignCommander\API\SOAP;

/**
 * Web service error
 */
class APIException extends \Exception
{
    private $status;

    public function __construct($message, $code, $previous)
    {
        parent::__construct($message, $code, $previous);

        if (!empty($previous->detail)) {
            if (!empty($previous->detail->status)) {
                $this->status = $previous->detail->status;
            }
            if (!empty($previous->detail->description)) {
                $this->message .= ' : ' . $previous->detail->description;
            }
        }
    }

    public function getStatus()
    {
        return $this->status;
    }
}
