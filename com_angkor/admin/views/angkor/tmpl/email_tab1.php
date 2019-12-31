<?php 
use Joomla\CMS\Factory;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

	$editor = Factory::getEditor();
	echo $editor->display('body', '', '100%', 370, 90, 30 );				
?>
<div class="clear"></div>
<div id="parameterArea"></div>			
