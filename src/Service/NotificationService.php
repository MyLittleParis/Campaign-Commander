<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\APIClient;
use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientInterface;

/**
 * NotificationService
 *
 * @author mylittleparis
 */
class NotificationService
{
    /**
     * @var APIClient
     */
    private $apiClient;

    
    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface $clientFactory
     */
    public function __construct(ClientFactoryInterface $clientFactory)
    {
        $this->apiClient = $clientFactory->createClient(ClientInterface::WSDL_URL_NOTIFICATION);
    }

    /**
     * Send object
     * 
     * This method is used to send a Transactional Message to an email address.
     * The response indicates whether the send was successful.
     *
     * @param int $uniqueIdentifier
     * @param string $random
     * @param string $securityTag
     * @param string $email
     * @param array $dyn
     * @param array $content
     * @param string $type
     * @param string $sendDate
     * @param string $uidKey
     *
     * @throws \Exception
     * @return string
     */
    public function sendObject(
        $uniqueIdentifier,
        $random,
        $securityTag,
        $email,
        array $dyn = null,
        array $content = null,
        $type = 'INSERT_UPDATE',
        $sendDate = null,
        $uidKey = 'email'
    ) {
        // List of valid type
        $allowedTypes = ['INSERT', 'UPDATE', 'INSERT_UPDATE', 'NOTHING'];

        // Check if type is valid
        if (!in_array($type, $allowedTypes)) {
            throw new \Exception('Invalid type ('. $type .'), allowed values are: '.implode(', ', $allowedTypes).'.');
        }

        $parameters['arg0'] = [
            'email' => (string) $email,
            'encrypt' => (string) $securityTag,
            'random' => (string) $random,
            'notificationId' => (int) $uniqueIdentifier,
            'senddate' => (null !== $sendDate) ? (int) $sendDate : time(),
            'synchrotype' => (string) $type,
            'uidkey' => (string) $uidKey,
        ];

        // Dynamic Personalization Parameters
        $parameters['arg0']['dyn'] = array();
        if (null !== $dyn) {
            foreach ($dyn as $key => $value) {
                $parameters['arg0']['dyn'] = [
                    'entry' => [
                        'key' => $key,
                        'value' => "<![CDATA[$value]]",
                    ]
                ];
            }
        }

        // Content Parameters
        $parameters['arg0']['content'] = array();
        if (null !== $content) {
            foreach ($content as $key => $value) {
                $parameters['arg0']['content'] = [
                    'entry' => [
                        'key' => $key,
                        'value' => "<![CDATA[$value]]",
                    ]
                ];
            }
        }

        return (string) $this->apiClient->doCall('sendObject', $parameters);
    }
}
