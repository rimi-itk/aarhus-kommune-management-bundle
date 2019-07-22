<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\DependencyInjection;

use ItkDev\AarhusKommuneManagementBundle\Controller\UserController;
use ItkDev\AarhusKommuneManagementBundle\Security\SecurityManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class AarhusKommuneManagementExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $definition = $container->getDefinition(SecurityManager::class);
        $definition->replaceArgument('$configuration', $config['security']);

        $definition = $container->getDefinition(UserController::class);
        $definition->replaceArgument(0, $config['users'] ?? []);
    }
}
