<?php
use Joomla\CMS\Language\Text;

/**
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<div id="submenu-box">
	<div class="submenu-box">
		<div class="submenu-pad">
			<ul id="submenu" class="configuration">
				<li><a href="#" onclick="return false;" id="angkorNavigator" class="active"><?php echo Text::_('EMAIL_EDITOR'); ?></a></li>
				<li><a href="#" onclick="return false;" id="cssNavigator"><?php echo Text::_('CSS_EDITOR'); ?></a></li>
				
			</ul>			
			<div class="clr"></div>
		</div>
	</div>
	<div class="clr"></div>
</div>
