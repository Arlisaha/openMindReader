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
                	->info('Path to the folder were assets will be dumped for open mind parser lib.')
                    ->children()
                        ->scalarNode('images')
		                    ->isRequired()
		                    ->cannotBeEmpty()
	                    ->end()
                ->end() //assets
            ->end()
        ;

        return $treeBuilder;
    }
}