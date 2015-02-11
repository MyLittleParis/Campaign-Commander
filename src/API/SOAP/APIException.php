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
            foreach ($previous->detail as $detail) {
                if (!empty($detail->status)) {
                    $this->status = $detail->status;
                }
                if (!empty($detail->description)) {
                    $this->message .= ' : ' . $detail->description;
                }
            }
        }
    }

    public function getStatus()
    {
        return $this->status;
    }
}
