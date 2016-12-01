<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() 
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('app');

        $rootNode
            ->children()
                ->arrayNode('file')
                    ->children()
                        ->scalarNode('folder_path')
                        	->info('Path to the folder with the .mm files to list.')
		                    ->isRequired()
		                    ->cannotBeEmpty()
	                    ->end()
                    ->end()
                ->end() //file
                ->arrayNode('assets')
                    ->children()
                        ->scalarNode('output')
                        	->info('Path to the folder were symfony assets will be dumped.')
		                    ->isRequired()
		                    ->cannotBeEmpty()
	                    ->end()
                ->end() //assets
            ->end()
        ;

        return $treeBuilder;
    }
}