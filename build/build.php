<?php
/* Program to create the angkor mailer package */

$version = "4.0.0";

$parts = ['com_angkor', 'plg_angkor_joomla', 'plg_system_angkor'];
$location = '../pkg_angkor/packages/';

/* This script expects to be run from within the build directory */
function zipit($what, $where = '../') {
	$zip = new ZipArchive;
	$zip->open($where.$what.'.zip', ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
	// Create recursive directory iterator
	/** @var SplFileInfo[] $files */
	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('../'.$what), RecursiveIteratorIterator::LEAVES_ONLY);

	foreach ($files as $name => $file)
	{
	    // Get real and relative path for current file
	    $filePath = $file->getPathName();
	    $relativePath = substr($filePath, strlen($what)+4);
	    if (!$file->isDir())
	    { 
	        // Add current file to archive
	        $zip->addFile($filePath, $relativePath);
	    }
	}

	// Zip archive will be created only after closing object
	$zip->close();
}
/* Make sure the packages directory exists and create it if it does not */
if (!file_exists($location) && !is_dir($location)) {
	mkdir($location);
}
/* Zip up each of the parts */
foreach ($parts as $part) {
	zipit($part, $location);
}
/* Now build the package */
zipit('pkg_angkor');
