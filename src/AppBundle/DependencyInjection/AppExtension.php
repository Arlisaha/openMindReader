<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Reference;

class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
	        $container,
	        new FileLocator(__DIR__.'/../Resources/config')
	    );
	    $loader->load('services.yml');
	    
	    $configuration = new Configuration();
	    $config = $this->processConfiguration($configuration, $configs);
	    
	    $container->setParameter('app.file.folder_path', $config['file']['folder_path']);
	    $container->setParameter('app.assets.images', $config['assets']['images']);
    }
}