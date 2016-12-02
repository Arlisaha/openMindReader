<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OpenMindParser\Converters\HTML\GenericHTMLConverter;
use Symfony\Component\HttpFoundation\Request;

class VisualizerController extends Controller
{
    public function htmlAction(Request $request, $fileName)
    {
		$filePath = $this->container->getParameter('app.file.folder_path').$fileName;
		
		if(!is_file($filePath)) {
			throw new \InvalidArgumentException(sprintf('The given file %s is not a valid filename.', $filePath));
		}
		
		$callback = function($fullName, $options = null){
			return '%'.$fullName.'%';
		};
		
		$htmlDocument = $this->container->get('app.converter.html')->convert(
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
					],
				],
			]
		);
		
		preg_match_all('~="%([^\s]+)%"~', $htmlDocument->saveHTML(), $imgsFiles);
		
        return $this->render('AppBundle::visualizer/html.html.twig', [
            'html_string' => $htmlDocument->saveHTML(),
            'img_files'   => array_unique($imgsFiles[1]),
        ]);
    }
}