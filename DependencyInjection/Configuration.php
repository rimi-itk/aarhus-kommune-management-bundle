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
        if (method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('aarhus_kommune_management');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // Symfony 3
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('aarhus_kommune_management');
        }

        $rootNode
            ->children()
                ->arrayNode('security')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('public_key')->defaultValue('%aarhus_kommune_management_public_key%')->end()
                        ->scalarNode('private_key')->defaultValue('%aarhus_kommune_management_private_key%')->end()
                        ->scalarNode('encryption_key')->defaultValue('%aarhus_kommune_management_encryption_key%')->end()
                        ->scalarNode('client_id')->defaultValue('%aarhus_kommune_management_client_id%')->end()
                        ->scalarNode('client_secret')->defaultValue('%aarhus_kommune_management_client_secret%')->end()

                        ->arrayNode('clients')
                            ->info('List of clients (overrides "client_id" and "client_secret")')
                            ->arrayPrototype()
                            ->children()
                                ->scalarNode('id')->isRequired()->end()
                                ->scalarNode('secret')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
