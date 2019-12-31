<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

require_once (JPATH_COMPONENT.'/helper/helper.php');
// Require the base controller
require_once (JPATH_COMPONENT.'/controller.php');

Table::addIncludePath(JPATH_COMPONENT.'/tables');

// Create the controller
$controller	= new AngkorController();

$view_name = Factory::getApplication()->input->get('view','angkor', 'STRING');
if($view_name!='')
{
	require_once(JPATH_COMPONENT.'/controllers/'.$view_name.".php");
	$controllerClass = 'AngkorController'.ucfirst($view_name);
	if (class_exists($controllerClass)) {
		$controller = new $controllerClass();
	} else {
		JError::raiseError(500, 'Invalid Controller Class');
	}
}

$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
?>