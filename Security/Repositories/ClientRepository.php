<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
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
    const CLIENT_NAME = 'My Awesome App';
    const REDIRECT_URI = 'http://foo/bar';

    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier)
    {
        $client = new ClientEntity();

        $client->setIdentifier($clientIdentifier);
        $client->setName(self::CLIENT_NAME);
        $client->setRedirectUri(self::REDIRECT_URI);

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $clients = [
      'myawesomeapp' => [
        'secret' => password_hash('abc123', PASSWORD_BCRYPT),
        'name' => self::CLIENT_NAME,
        'redirect_uri' => self::REDIRECT_URI,
        'is_confidential' => true,
      ],
    ];

        // Check if client is registered.
        if (false === \array_key_exists($clientIdentifier, $clients)) {
            return;
        }

        if (
          true === $clients[$clientIdentifier]['is_confidential']
          && false === password_verify($clientSecret, $clients[$clientIdentifier]['secret'])
      ) {
            return;
        }
    }
}
