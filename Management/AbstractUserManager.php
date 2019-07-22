<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Management;

abstract class AbstractUserManager
{
    /**
     * Get users.
     */
    abstract public function getUsers();

    /**
     * Create user.
     */
    abstract public function createUser(array $data);

    /**
     * Update user.
     */
    abstract public function updateUser(array $data);

    /**
     * Delete user.
     */
    abstract public function deleteUser(array $data);

    /**
     * Serialize user.
     */
    abstract public function serializeUser($user);
}
