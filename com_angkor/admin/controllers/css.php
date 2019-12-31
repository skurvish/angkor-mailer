<?php
use Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

class AngkorControllerCSS extends angkorController
{
	function apply()
	{			
		$model = $this->getModel('css');
		$model->saveCSS();
		
		$data = array();
		$data['result']=1;
		$data['message']=Text::_('CSS_STORED');
		ob_clean();
		echo json_encode($data);
		exit(0);
	}
	
}
?>