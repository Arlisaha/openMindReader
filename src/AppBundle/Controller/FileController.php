<?php

namespace AppBundle\Controller;

use AppBundle\File\TreeBuilder as FileTreeBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FileController extends Controller
{
    public function listAction()
    {
		$directoryPath = $this->container->getParameter('app.file.folder_path');
			
		$fileTreeBuilder = new FileTreeBuilder();
			
        return $this->render('AppBundle::file/list.html.twig', [
            'file_list' => $fileTreeBuilder->build($directoryPath, 'mm'),
        ]);
    }
}
