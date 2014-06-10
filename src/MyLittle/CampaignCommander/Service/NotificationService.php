<?php

namespace MyLittle\CampaignCommander\Service;

use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;

/**
 * NotificationService
 *
 * @author mylittleparis
 */
class NotificationService extends AbstractService
{
    /**
     * Constructor
     *
     * @param \MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->soapClient = $client;
        $this->soapClient->setWsdl(ClientInterface::WSDL_URL_NOTIFICATION);
        $this->soapClient->setServer('http://api.notificationmessaging.com');
    }

    /**
     * Send object
     * This method is used to send a Transactional Message to an email address.
     * The response indicates whether the send was successful.
     *
     * @param string $uniqueIdentifier
     * @param string $securityTag
     * @param string $email
     * @param array $dyn
     * @param array $content
     * @param string $type
     * @param string $sendDate
     * @param string $uidKey
     *
     * @return string
     *
     * @throws Exception
     */
    public function sendObject($uniqueIdentifier,
                                $securityTag,
                                $email,
                                array $dyn = null,
                                array $content = null,
                                $type = 'INSERT_UPDATE',
                                $sendDate = null,
                                $uidKey = 'email')
    {
        // List of valid type
        $allowedTypes = ['INSERT', 'UPDATE', 'INSERT_UPDATE', 'NOTHING'];

        // Check if type is valid
        if (!in_array($type, $allowedTypes)) {
            throw new \Exception('Invalid type (' . $type . '), allowed values are: ' . implode(', ', $allowedTypes) . '.');
        }

        $parameters['sendrequest'] = [
            'email' => (string) $email,
            'encrypt' => (string) $securityTag,
            'random' => (string) $uniqueIdentifier,
            'senddate' => (null !== $sendDate) ? (int) $sendDate : time(),
            'synchrotype' => (string) $type,
            'uidkey' => (string) $uidKey,
        ];

        // Dynamic Personalization Parameters
        if (null !== $dyn) {
            foreach($dyn as $key => $value) {
                $parameters['sendrequest']['dyn'] = [
                    'entry' => [
                        'key' => $key,
                        'value' => "<![CDATA[$value]]",
                    ]
                ];
            }
        }

        // Content Parameters
        if (null !== $content) {
            foreach($content as $key => $value) {
                $parameters['sendrequest']['content'] = [
                    'entry' => [
                        'key' => $key,
                        'value' => "<![CDATA[$value]]",
                    ]
                ];
            }
        }

        return $this->soapClient->doCall('sendObject', $parameters);
    }
}
