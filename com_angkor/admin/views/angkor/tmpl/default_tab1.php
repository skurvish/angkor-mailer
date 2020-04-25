<?php 
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<form method="post" action="index.php?option=com_angkor" name="adminForm" id="adminForm">
	<div class="angkorTempate">
		<div class="angkorTempate-inner">
			<div id="emailsList">
				<div class="languages" id="languageArea">
				<?php echo $this->languages_list;?>
				</div>
				<div class="emails" id="emails">
				<?php
					$option = Factory::getApplication()->input->get('option');
					echo HTMLHelper::_('sliders.start','sliders-'.$option);
					$i=0;
					foreach($this->emailslist as $key=>$emails){
						$i++;
						$label = Text::_($key);
						
						echo HTMLHelper::_('sliders.panel',$label, 'slider-' . $i);
						?>
						<table class="emailsList">
							<thead>
							<tr>
								<th><?php echo Text::_('COLUMN_ID');?></th>
								<th><?php echo Text::_('COLUMN_EVENT');?></th>
								<th><?php echo Text::_('COLUMN_TO');?></th>
								<th><?php echo Text::_('COLUMN_SPECIFIC');?></th>
							</tr>
							</thead>
						<?php
						$i=0;
						foreach($emails as $email){
							$i++;
							?>
							<tr>
								<td align="center"><?php echo $i;?></td>
								<td><?php echo '<a href="index.php?option=com_angkor&code='.$email['code'].'&view=angkor"class="email-links"><span>'.$email['title']. '</span></a>';?></td>
								<td><?php echo $email['to'];?></td>
								<td><?php echo $email['description'];?></td>
							</tr>
							<?php
						}			
						echo '</table>';
					}
					echo HTMLHelper::_('sliders.end');
				?>
				</div>
			</div>
			<div id="emailTemplate">
				<?php echo $this->loadTemplate('email');?>
				<div class="clear"></div>
			</div>			
		</div>
		<div class="clear"></div>
		<br />
	</div>
	<input type="hidden" name="view" value="angkor">
	<input type="hidden" name="task" id="task" value="">
	<input type="hidden" name="option" value="com_angkor">
	<input type="hidden" name="mycss" id="mycss" value="" />
</form>

<script language="javascript">
	window.addEvent('load',function(){resizeEmailsList();});
</script>