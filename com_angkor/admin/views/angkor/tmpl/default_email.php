<?php 
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

	$option = Factory::getApplication()->input->get('option');
	echo HTMLHelper::_('tabs.start','tabs-'.$option);
		$label = Text::_('EMAIL_TAB1');
		echo HTMLHelper::_('tabs.panel',$label, 'tab-1');
		include('email_tab1.php');
		
		$label = Text::_('EMAIL_TAB2');
		echo HTMLHelper::_('tabs.panel',$label, 'tab-2');
		include('email_tab2.php');
		
		$label = Text::_('EMAIL_TAB3');
		echo HTMLHelper::_('tabs.panel',$label, 'tab-3');
		include('email_tab3.php');	
		
	echo HTMLHelper::_('tabs.end');	
?>
<input type="hidden" name="lang"  id="lang" value="" />
<input type="hidden" name="code"  id="code" value="" />
<input type="hidden" name="id"  id="id" value="" />
<input type="hidden" name="changed"  id="changed" value="" />