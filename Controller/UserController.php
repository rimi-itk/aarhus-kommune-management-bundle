<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-bundle.
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
        try {
            $this->securityManager->validateToken();
            $users = $this->userManager->getUsers();

            return new JsonResponse([
                'data' => array_map([$this->userManager, 'serializeUser'], $users),
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse(['code' => $exception->getCode(), 'message' => $exception->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $this->securityManager->validateToken();
            $payload = json_decode($request->getContent(), true);

            $result = [];

            if (isset($payload['users'])) {
                $commands = $payload['users'];

                if (isset($commands['create']) && \is_array($commands['create'])) {
                    foreach ($commands['create'] as $item) {
                        $user = $this->userManager->createUser($item);
                        $result['create'][] = $user;
                    }
                }

                if (isset($commands['update']) && \is_array($commands['update'])) {
                    foreach ($commands['update'] as $item) {
                        $user = $this->userManager->updateUser($item);
                        $result['update'][] = $user;
                    }
                }
            }

            return new JsonResponse($result);
        } catch (\Exception $exception) {
            return new JsonResponse(['code' => $exception->getCode(), 'message' => $exception->getMessage()]);
        }
    }
}
