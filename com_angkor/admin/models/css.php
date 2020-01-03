<?php
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

//jimport('joomla.language.helper');
//jimport('joomla.application.component.model');

class AngkorModelCSS extends BaseDatabaseModel
{
	function __construct()
	{
		parent::__construct();

	}	
	function getActions()
	{
		$user	= Factory::getUser();
		$result	= new CMSObject;

		$assetName = 'com_angkor';		

		$actions = array('core.admin', 'core.manage',  'core.edit');

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}
		return $result;
	}
	function getCSS()
	{
		$css = angkor_Helper::getCSS();		
		return $css;
	}
	function saveCSS(){
		$columns = ['id'=>'INT', 'css'=>'RAW'];

		$data_css = angkor_Helper::getCSS();		
	
		$css = Table::getInstance('css', 'Table',array());		
		$css->bind(Factory::getApplication()->input->getArray($columns));
		if($data_css)	
			$css->id = $data_css->id;
		$css->store();		
		return $css;
	}
}