<?php

/*
 * This file is part of itk-dev/aarhus-kommune-management-symfony-4.
 *
 * (c) 2019 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace ItkDev\AarhusKommuneManagementBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('aarhus_kommune_management');

        $treeBuilder->getRootNode()
            ->children()

            ->arrayNode('security')->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('public_key')->defaultValue('%aarhus_kommune_management_public_key%')->end()
            ->scalarNode('private_key')->defaultValue('%aarhus_kommune_management_private_key%')->end()
            ->scalarNode('encryption_key')->defaultValue('%aarhus_kommune_management_encryption_key%')->end()
            ->end()
            ->end()

//            ->arrayNode('users')->isRequired()
//            ->children()
//            ->scalarNode('manager')->isRequired()->end()
//            ->end()
//            ->end()

            ->end();

        return $treeBuilder;
    }
}
