<?php
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Language\Text;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class angkorController extends BaseController
{
	/**
	 * Constructor
	 *
	 * @params	array	Controller configuration array
	 */
	function __construct($config = array())
	{
		parent::__construct($config);

	}

	/**
	 * Displays a view
	 */
//	function display( )
//	{
//		parent::display();
//	}
	
	function ajax(){			
		$code = JFactory::getApplication()->input->get('code');
		$lang = Factory::getApplication()->input->get('lang');
		
		$data = angkor_Helper::getEmail($code,$lang);
		
		$availableFields = angkor_Helper::getAvailableFieldParameters($code);
		if($availableFields=='')
			$data['parameters'] =  Text::_('VM_OTHER_MESSAGE_AVAILABLE_FIELS') . ' : '. Text::_('NO_FIELDS_PARAMETERS_AVAILABLE');
		else
			$data['parameters'] = Text::_('VM_OTHER_MESSAGE_AVAILABLE_FIELS') . ' : '. $availableFields;
		
		
		ob_clean();
		echo json_encode($data);
		exit(0);
	}
}
