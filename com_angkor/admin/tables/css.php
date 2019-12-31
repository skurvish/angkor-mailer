<?php
use Joomla\CMS\Table\Table;

defined('_JEXEC') or die( 'Restricted access' );

class JTableCSS extends Table
{
	function __construct( &$_db )
	{
		parent::__construct( '#__angkor_css', 'id', $_db);		
	}	
}