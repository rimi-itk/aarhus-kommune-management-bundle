<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-bundle.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\Security\Entities;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

class ClientEntity implements ClientEntityInterface
{
    use EntityTrait;
    use ClientTrait;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
    }
}
