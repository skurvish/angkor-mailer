<?php
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

//jimport( 'joomla.application.component.view');

class AngkorViewAngkor extends HtmlView
{
	function display($tpl = null)
	{
		global $mainframe, $option;
		$model = $this->getModel();
		
		$languages_list = $model->get_language_list('language');
		$this->assignRef('languages_list',$languages_list);
		

		$emailslist = angkor_Helper::getEmailsList();
		$this->assignRef('emailslist',$emailslist);
		
		$css = $model->getCSS();
		$this->assignRef('css',$css);		

		$this->addToolbar();				
		parent::display($tpl);
	}
	function addToolbar()
	{
		$model = $this->getModel();
		$canDo = $model->getActions();
		
		if ($canDo->get('core.edit')) {
			JToolBarHelper::apply();
			//JToolBarHelper::save();				
			//JToolBarHelper::cancel();				
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();	
			JToolBarHelper::preferences('com_angkor');			
		}				
		JToolBarHelper::title( Text::_('COMPONENT_TITLE'),'angkor');
	}
}