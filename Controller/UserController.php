<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Controller;

use ItkDev\AarhusKommuneManagementBundle\Management\AbstractUserManager;
use ItkDev\AarhusKommuneManagementBundle\Security\SecurityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController.
 */
class UserController
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * The user manager.
     *
     * @var AbstractUserManager
     */
    private $userManager;

    /**
     * @var SecurityManager
     */
    private $securityManager;

    public function __construct(array $configuration, AbstractUserManager $userManager, SecurityManager $securityManager)
    {
        $this->configuration = $configuration;
        $this->userManager = $userManager;
        $this->securityManager = $securityManager;
    }

    public function index()
    {
        $this->securityManager->validateToken();
        $users = $this->userManager->getUsers();

        return new JsonResponse(array_map([$this->userManager, 'serializeUser'], $users));
    }

    public function update(Request $request)
    {
        $this->securityManager->validateToken();
        $data = json_decode($request->getContent(), true);

        $result = $this->userManager->updateUser($data);

        return new JsonResponse($result);
    }
}
