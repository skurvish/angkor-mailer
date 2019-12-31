<?php 
use Joomla\CMS\HTML\HTMLHelper;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

HTMLHelper::_('behavior.switcher');
HTMLHelper::_('behavior.tooltip');
angkor_Helper::loadAssets();
$this->document->setBuffer($this->loadTemplate('navigation'), 'modules', 'top');

?>

<div id="config-document">
	<div id="angkorMessage">test</div>
	<div id="page-angkorNavigator" class="tab">
		<div class="noshow">
			<?php include('default_tab1.php'); ?>
		</div>
	</div>
	<div id="page-cssNavigator" class="tab">
		<div class="noshow">
			<?php include('default_tab2.php'); ?>
		</div>
	</div>
</div>
<script language="javascript">
	Joomla.submitbutton = function(task){
							if(task=='apply'){
								if(jQuery('#page-angkorNavigator').css('display')!='none')
									ajaxSubmitEmailForm();
									
								if(jQuery('#page-cssNavigator').css('display')!='none')
									ajaxSubmitCSSForm();
							}
						}
</script>