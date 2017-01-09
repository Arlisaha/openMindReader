<?php

namespace AppBundle\File;

use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;
use \RegexIterator;
use \RecursiveRegexIterator;

class TreeBuilder
{
	/**
	 * Build the file tree.
	 * 
	 * @param String $directoryPath : The path of the current directory whom files are beeing listed from.
	 * @param String $filesExtension : the files extension(s) we want to display. It's a regex used in a preg_match on each file.
	 * 
	 * @return array : e representation of the file tree.
	 */
	public function build($directoryPath, $filesExtension = '.*')
	{
		return $this->buildArray($directoryPath, sprintf('~\.%s$~', $filesExtension));
	}
	
	/**
	 * Method called recursively to build the file tree.
	 * 
	 * @param String $directoryPath : The path of the current directory whom files are beeing listed from.
	 * @param String $filesExtension : the files extension(s) we want to display. It's a regex used in a preg_match on each file.
	 * @param String $pathPrefix : Use for deepness. On the first level it is '' and then the folders are added.
	 * 
	 * @return array : e representation of the file tree.
	 */
	private function buildArray($directoryPath, $filesExtension, $pathPrefix = '')
	{
		$list = scandir($directoryPath);
		$fileList = [];
		foreach($list as $file) {
			if($file !== '.' && $file !== '..') {
				if(is_dir($newDirectoryPath = $directoryPath.'/'.$file)) {
					$fileList[urlencode($pathPrefix.$file)] = $this->buildArray($newDirectoryPath, $filesExtension, $pathPrefix.$file.'/');
				} elseif(preg_match($filesExtension, $file)) {
					$fileList[urlencode($pathPrefix.$file)] = $file;
				}
			}
		}
		
		return $fileList;
	}
}