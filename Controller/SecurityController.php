<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Controller;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use ItkDev\AarhusKommuneManagementBundle\Security\Repositories\AccessTokenRepository;
use ItkDev\AarhusKommuneManagementBundle\Security\Repositories\ClientRepository;
use ItkDev\AarhusKommuneManagementBundle\Security\Repositories\ScopeRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;

/**
 * Class SecurityController.
 */
class SecurityController
{
    /**
     * The configuration.
     *
     * @var array
     */
    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function authenticate()
    {
        $clientRepository = new ClientRepository();
        $scopeRepository = new ScopeRepository();
        $accessTokenRepository = new AccessTokenRepository();

        // Path to public and private keys.
        $privateKey = $this->configuration['private_key'];
        // Generate using base64_encode(random_bytes(32))
        $encryptionKey = $this->configuration['encryption_key'];

        $server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $encryptionKey
        );

        $server->enableGrantType(
            new ClientCredentialsGrant(),
            // Access tokens will expire after 1 hour.
            new \DateInterval('PT1H')
        );

        $request = ServerRequest::fromGlobals();
        $response = new Response();
        $result = $server->respondToAccessTokenRequest($request, $response);

        return new \Symfony\Component\HttpFoundation\Response(
            (string) $result->getBody(),
            $result->getStatusCode(),
            $result->getHeaders()
        );
    }
}
