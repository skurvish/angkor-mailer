<?php
/* Program to create the angkor mailer package */

$version = "v4.0";

$parts = [ ['folder' => 'com_angkor', 'xml' => 'com_angkor'],
			['folder' => 'plg_angkor_joomla', 'xml' => 'joomla'],
			['folder' => 'plg_system_angkor', 'xml' => 'angkor'],
		];
$location = '../pkg_angkor/packages/';
$package = '../pkg_angkor/';

/* This script expects to be run from within the build directory */
function zipit($what, $where = '../') {
	global $version, $location;
	/* First update the version number in the xml file */
	$xmlfile = '../'.$what['folder'].'/'.$what['xml'].'.xml';
	$xml = file_get_contents($xmlfile.'.tmpl'); ;
	$xml = str_replace('{version}', $version, $xml);
	file_put_contents($xmlfile, $xml);

	$zip = new ZipArchive;
	$zip->open($where.$what['folder'].'_'.$version.'.zip', ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
	// Create recursive directory iterator
	/** @var SplFileInfo[] $files */
	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('../'.$what['folder']), RecursiveIteratorIterator::LEAVES_ONLY);

	foreach ($files as $name => $file)
	{
	    if (strpos($name, $xmlfile.'.tmpl') === 0) continue;	/* Ignore the xml template */
	    // Get real and relative path for current file
	    $filePath = $file->getPathName();
	    $relativePath = substr($filePath, strlen($what['folder'])+4);
	    if (!$file->isDir())
	    { 
	        // Add current file to archive
	        $zip->addFile($filePath, $relativePath);
	    }
	}

	// Zip archive will be created only after closing object
	$zip->close();
	/* And remove the modified xml file */
	unlink($xmlfile);
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
zipit(['folder' => 'pkg_angkor', 'xml' => 'pkg_angkor']);

/* And remove the individual zips */
foreach ($parts as $part) {
	unlink($location.$part['folder'].'_'.$version.'.zip');
}
/* And remove the packages directory */
rmdir($location);