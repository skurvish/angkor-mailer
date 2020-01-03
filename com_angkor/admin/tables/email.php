<?php
use Joomla\CMS\Table\Table;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class TableEmail extends Table
{
	function __construct( &$_db )
	{
		parent::__construct( '#__angkor_emails', 'id', $_db);		
	}	
}
?>
