<?php

namespace AppBundle\Controller;

use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;
use \RegexIterator;
use \RecursiveRegexIterator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FileController extends Controller
{
    public function listAction()
    {
		$directoryPath = $this->container->getParameter('app.file.folder_path');
	
		$directory = new RecursiveDirectoryIterator($directoryPath);
		$iterator = new RecursiveIteratorIterator($directory);
		$regex = new RegexIterator($iterator, '/^.+\.mm$/i', RecursiveRegexIterator::GET_MATCH);
		$fileList = iterator_to_array($regex);
		array_walk($fileList, function(&$value, $key, $path) {
			$value = str_replace($path, '', $value[0]);
		}, $directoryPath);
		
		$newFileList = [];
		foreach($fileList as $filePath => $fileName) {
			if(preg_match('~^(.*)/.*\.mm$~', $fileName, $matches)) {
				$key = $matches[1];
				if(!array_key_exists($key, $newFileList)) {
					$newFileList[$key] = [];
				}
				$newFileList[$key][urlencode($fileName)] = str_replace($key.'/', '', $fileName);
			}
			else {
				$newFileList[urlencode($fileName)] = $fileName;
			}
			
		}
			
        return $this->render('AppBundle::file/list.html.twig', [
            'file_list' => $newFileList,
        ]);
    }
}
