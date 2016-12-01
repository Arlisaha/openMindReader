<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OpenMindParser\Converters\HTML\GenericHTMLConverter;

class VisualizerController extends Controller
{
    public function htmlAction($fileName)
    {
		$filePath = $this->container->getParameter('app.file.folder_path').$fileName;
		
		if(!is_file($filePath)) {
			throw new \InvalidArgumentException(sprintf('The given file %s is not a valid filename.', $filePath));
		}
		
		$callback = function($fullName, $options = null){
			return $options[0]->getUrl($options[1].$fullName);
		};
		
		$htmlDocument = $this->container->get('open_mind_reader.converter.html')->convert(
			$filePath, 
			[
				GenericHTMLConverter::MAIN_TAG_KEY => [
					[
						GenericHTMLConverter::TAG_KEY        => 'ul', 
						GenericHTMLConverter::ATTRIBUTES_KEY => [
							'class' => 'collapsibleList',
						],
					], 
					[
						GenericHTMLConverter::TAG_KEY        => 'li', 
						GenericHTMLConverter::ATTRIBUTES_KEY => [],
					],
				],
				GenericHTMLConverter::MAIN_ICON_KEY => [
					GenericHTMLConverter::DISPLAY_ICON_KEY => true,
					GenericHTMLConverter::PATH_ICON_KEY    => [
						GenericHTMLConverter::CALLBACK_PATH_ICON_KEY => $callback,
						GenericHTMLConverter::OPTIONS_PATH_ICON_KEY  => [
							$this->get('assets.packages'), 
							$this->container->getParameter('app.assets.images'),
						],
					],
				],
			]
		);
		
        return $this->render('AppBundle::visualizer/html.html.twig', [
            'html_string' => $htmlDocument->saveHTML(),
        ]);
    }
}