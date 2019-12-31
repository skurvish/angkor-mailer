<?php 
use Joomla\CMS\Language\Text;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>

<table>
	<tr> 
		<td width="15%" align="right"><?php echo Text::_('JOOMLA_SENDER_NAME'); ?>:</td>
		<td width="85%">
			<input type="text" class="inputbox" name="sender_name"  id="sender_name" value="" style="width:500px" size="250"/>
		</td>
	</tr>
	<tr> 
		<td width="15%" align="right"><?php echo Text::_('JOOMLA_SENDER_EMAIL'); ?>:</td>
		<td width="85%">
			<input type="text" class="inputbox" name="sender_email" id="sender_email" value="" style="width:500px" size="250"/>
		</td>
	</tr>
	<tr> 
		<td width="15%" align="right"><?php echo Text::_('JOOMLA_EMAIL_SUBJECT'); ?>:</td>
		<td width="85%">
			<input type="text" class="inputbox" name="subject" id="subject" value="" style="width:500px" size="250"/>
		</td>
	</tr>
	<tr> 
		<td width="15%" align="right" valign="top"><?php echo Text::_('EMBED_IMAGES'); ?>:</td>
		<td width="85%"> 
			<input type="checkbox" name="embed_image" id="embed_image" value="1" />
		</td>		
	</tr>	
</table>