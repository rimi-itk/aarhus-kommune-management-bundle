<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-bundle.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Security\Repositories;

use ItkDev\AarhusKommuneManagementBundle\Security\Entities\ClientEntity;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var array
     */
    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier)
    {
        $client = new ClientEntity();

        $client->setIdentifier($clientIdentifier);

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $clients = $this->getClients();

        foreach ($clients as $client) {
            if ($clientIdentifier === $client['id'] && $clientSecret === $client['secret']) {
                return true;
            }
        }

        return false;
    }

    private function getClients()
    {
        if (!empty($this->configuration['clients'])) {
            return $this->configuration['clients'];
        } else {
            return [
                [
                    'id' => $this->configuration['client_id'],
                    'secret' => $this->configuration['client_secret'],
                ],
            ];
        }
    }
}
