<?php

namespace AppBundle\File;

use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;
use \RegexIterator;
use \RecursiveRegexIterator;

class TreeBuilder
{
	public function build($directoryPath, $filesExtension = '.*')
	{
		$directory = new RecursiveDirectoryIterator($directoryPath);
		$iterator = new RecursiveIteratorIterator($directory);
		$regex = new RegexIterator($iterator, '~^.+\.'.$filesExtension.'$~i', RecursiveRegexIterator::GET_MATCH);
		$fileList = iterator_to_array($regex);
		array_walk($fileList, function(&$value, $key, $path) {
			$value = str_replace($path, '', $value[0]);
		}, $directoryPath);
		
		return $this->buildArray($fileList, $filesExtension);
	}
	
	private function buildArray(array $fileList, $filesExtension)
	{
		$newFileList = [];
		foreach($fileList as $filePath => $fileName) {
			if(preg_match('~^(.*)/.*\.'.$filesExtension.'$~', $fileName, $matches)) {
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
		
		return $newFileList;
	}
}