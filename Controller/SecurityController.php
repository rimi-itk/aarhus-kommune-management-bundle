<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-bundle.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Controller;

use ItkDev\AarhusKommuneManagementBundle\Security\SecurityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SecurityController.
 */
class SecurityController
{
    /**
     * @var SecurityManager
     */
    private $securityManager;

    public function __construct(SecurityManager $securityManager)
    {
        $this->securityManager = $securityManager;
    }

    public function authenticate()
    {
        try {
            $result = $this->securityManager->createToken();

            return new Response(
                (string) $result->getBody(),
                $result->getStatusCode(),
                $result->getHeaders()
            );
        } catch (\Exception $exception) {
            return new JsonResponse(['code' => $exception->getCode(), 'message' => $exception->getMessage()]);
        }
    }
}
