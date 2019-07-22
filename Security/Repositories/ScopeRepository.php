<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Security\Repositories;

use ItkDev\AarhusKommuneManagementBundle\Security\Entities\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        $scopes = [
      'data:write' => [
        'description' => 'data:write',
      ],
      'data:read' => [
        'description' => 'date:read',
      ],
    ];

        if (false === \array_key_exists($scopeIdentifier, $scopes)) {
            return;
        }

        $scope = new ScopeEntity();
        $scope->setIdentifier($scopeIdentifier);

        return $scope;
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
      array $scopes,
      $grantType,
      ClientEntityInterface $clientEntity,
      $userIdentifier = null
    ) {
        return $scopes;
    }
}
