<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FileController extends Controller
{
    public function listAction()
    {
		$directoryPath = $this->container->getParameter('app.file.folder_path');
		
		$directoryContent = scandir($directoryPath);
		
		$filesList = [];
		foreach($directoryContent as $file) {
			if(($file !== '.') && ($file !== '..') && (is_file($directoryPath.$file))) {
				$filesList[] = $file;
			}
		}
		
        return $this->render('AppBundle::file/list.html.twig', [
            'file_list' => $filesList,
        ]);
    }
}
