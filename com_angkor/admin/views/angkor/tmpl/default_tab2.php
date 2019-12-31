<?php
use Joomla\CMS\Language\Text;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>

<form method="post" action="index.php?option=com_angkor" name="adminCSSForm" id="adminCSSForm">
	<textarea id="css" name="css" class="css-editor" rows="40"><?php echo ($this->css->css?$this->css->css:Text::_('EMPTY_CSS'));?></textarea>
	<div class="css-warning"><?php echo Text::_('CSS_WARNING');?></div>
	<input type="hidden" name="id" value="<?php echo $this->row->id;?>">
	<input type="hidden" name="task" value="">
	<input type="hidden" name="view" value="css">
	<input type="hidden" name="option" value="com_angkor">
</form>
<script>
	var CodeMirrorEditor = CodeMirror.fromTextArea(document.getElementById("css"), {});
</script>