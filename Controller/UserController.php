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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController.
 */
class UserController
{
    /**
     * The user manager.
     *
     * @var AbstractUserManager
     */
    private $userManager;

    public function __construct(array $configuration, /*AbstractUserManager*/ $userManager)
    {
        $this->userManager = $userManager;
    }

    public function index(Request $request)
    {
        $users = $this->userManager->getUsers();

        return new JsonResponse($users);
    }

    public function update(Request $request)
    {
        $data = json_decode($request->getContent());

        $result = $this->userManager->updateUser($data);
    }
}
