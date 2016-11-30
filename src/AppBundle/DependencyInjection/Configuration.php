<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() 
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('open_mind_reader');

        $rootNode
            ->children()
                ->arrayNode('file')
                    ->children()
                        ->scalarNode('folder_path')->end()
                    ->end()
                ->end() //file
            ->end()
        ;

        return $treeBuilder;
    }
}