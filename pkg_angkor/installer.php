<?php
use Joomla\CMS\Factory;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class pkg_AngkorInstallerScript {
	function postflight()
	{
		$db = Factory::getDBO();
		$query ="UPDATE `#__extensions` SET `enabled`=1 
				WHERE `type`='plugin' 
				AND `element`='angkor' 
				AND `folder`='system'";
				
		$db->setQuery($query);
		$db->query();
		
		$query ="UPDATE `#__extensions` SET `enabled`=1 
				WHERE `type`='plugin' 
				AND `element`='joomla' 
				AND `folder`='angkor'";
				
		$db->setQuery($query);
		$db->query();
	}
}
?>