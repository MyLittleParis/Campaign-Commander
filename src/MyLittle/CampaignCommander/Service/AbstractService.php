<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * AbstractService
 *
 * @author mylittleparis
 */
abstract class AbstractService
{
    /**
     * @var ClientInterface
     */
    protected $soapClient;

    /**
     * Get the attributes entry of the response
     *
     * @param mixed $response
     *
     * @return array
     */
    protected function getAttributesEntry($response)
    {
        $AttributesEntry = [];
        foreach ($response->attributes->entry as $entry) {
            $key = (string) $entry->key;
            $value = (isset($entry->value)) ? $entry->value : null;

            // convert the DATEJOIN key to timestamp UNIX
            if ($key == 'DATEJOIN' && $value !== null) {
                $value = (int) strtotime($value);
            }

            $AttributesEntry[$key] = $value;
        }

        return $AttributesEntry;
    }
}
