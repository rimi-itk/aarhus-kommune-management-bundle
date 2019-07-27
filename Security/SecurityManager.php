<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Security;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use ItkDev\AarhusKommuneManagementBundle\Security\Repositories\AccessTokenRepository;
use ItkDev\AarhusKommuneManagementBundle\Security\Repositories\ScopeRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\ResourceServer;

class SecurityManager
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @var ClientRepositoryInterface
     */
    private $clientRepository;

    /**
     * SecurityManager constructor.
     *
     * @param array $configuration
     */
    public function __construct(/*array */$configuration, /*ClientRepositoryInterface */$clientRepository)
    {
        $this->configuration = $configuration;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Create token.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function createToken()
    {
        $scopeRepository = new ScopeRepository();
        $accessTokenRepository = new AccessTokenRepository();

        // Path to public and private keys.
        $privateKey = $this->configuration['private_key'];
        // Generate using base64_encode(random_bytes(32))
        $encryptionKey = $this->configuration['encryption_key'];

        $server = new AuthorizationServer(
            $this->clientRepository,
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

        return $server->respondToAccessTokenRequest($request, $response);
    }

    /**
     * Validate token.
     */
    public function validateToken()
    {
        $accessTokenRepository = new AccessTokenRepository();
        $publicKey = $this->configuration['public_key'];

        $server = new ResourceServer(
            $accessTokenRepository,
            $publicKey
        );
        $request = ServerRequest::fromGlobals();

        return $server->validateAuthenticatedRequest($request);
    }
}
