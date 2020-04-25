<?php
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Component\ComponentHelper;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
//jimport('joomla.language.helper');
//jimport('joomla.application.component.model');

class AngkorModelAngkor extends BaseDatabaseModel
{
	function __construct(){
		parent::__construct();

	}
	function getnewEmail(){
		$email = Table::getInstance('emailmsg', 'Table',array());		
		$email->bind(Factory::getApplication()->input->get('post'));
		return $email;
	}
	function getEmail(){
		$code = Factory::getApplication()->input->get('code', '', 'STRING');
		$lang_id = Factory::getApplication()->input->get('lang_id', 0, 'INT');
		$db = Factory::getDBO();
		$q =" Select * 
			From `#__nu_emailmsg` 
			WHERE `code`='" . $code . "'
			AND `lang_id`='".$lang_id."'";
		$db->setQuery($q);				
		return $db->loadObject();			
	}
	function getAvailableFieldParameters(){
		$code = Factory::getApplication()->input->get('code', '', 'STRING');
		if($code)
		{
			$dbFields =Factory::getDBO();
			$q="Select * 
				From `#__angkor_email_fields` 
				WHERE `code`='" . $code . "'";
			$fields=array();
			$dbFields->setQuery($q);				
			$rows=$dbFields->loadObjectList();				
			if($rows)
			{
				foreach($rows as $row)
				{
					$fields[]= '<a href="javascript:jInsertEditorText(\''. $row->field_name.'\',\'body\')">' . $row->field_name  . '</a>';
				}
			}
			return implode(' , ',$fields);
		}
	}
	function get_Active_Languages(){
		$params = ComponentHelper::getParams('com_languages');
		$tag =  $params->get('site');			
		
		$db = Factory::getDBO();
		$query ="SELECT * FROM `#__languages` WHERE `lang_code`='{$tag}'";		
		$db->setQuery($query);
		$row = $db->loadObject();
		if(!$row) //Default language is not being added to Language contents. So we add them.
		{				
			$lang_table = Table::getInstance('extension');
			$id = $lang_table->find(
									array(	'element' => $tag
											,'type'=>'language'
											,'client_id'=>0
										)
							);
			$lang_table->load($id);
			$lang_params = new Registry($lang_table->manifest_cache);
			
			$table = Table::getInstance('language');			
			$table->lang_code =$tag;
			$table->title =$lang_params->get('name',$tag);
			$table->title_native =$lang_params->get('name',$tag);
			
			$sef = strtolower(substr($tag,0,2));
			$table->sef =$sef;
			$table->image =$sef;
			$table->published =1;
			$table->store();			 
		}		
		$languages	= LanguageHelper::getLanguages();						
		return $languages;
	}
	function get_language_list($name,$select_language=''){		
		$languages=$this->get_Active_Languages();
		
		if(COUNT($languages)<5)
			$item_visible = COUNT($languages);
		else
			$item_visible = 5;
		$html='<select name="'.$name.'"  id="'.$name.'" size="'.$item_visible.'">';
		
		$i=0;
		foreach($languages as $language)
		{
			$i++;
			$value = $language->sef;
			$text = $language->title;
			if($value==$select_language OR ($select_language=='' AND $i==1) )
				$html .='<option value="'.$value.'" selected="true">'.$text.'</option>';
			else
				$html .='<option value="'.$value.'">'.$text.'</option>';
		}
		$html .='</select>';
		return $html;
	}
	function get_selected_language($language_id){
		$languages	= LanguageHelper::getLanguages();
		foreach($languages as $language)
		{
			if($language->lang_id==$language_id)
				return $language;
		}		
	}
	function getActions(){
		$user	= Factory::getUser();
		$result	= new CMSObject;

		$assetName = 'com_angkor';		

		$actions = array('core.admin', 'core.manage',  'core.edit');

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}	
	function save_mail(){ 
		$columns = ['id'=>'INT', 
					'code'=>'STRING', 
					'subject'=>'STRING', 
					'body'=>'RAW', 
					'sender_name'=>'STRING', 
					'sender_email'=>'STRING',
					'lang'=>'STRING',
					'embed_image'=>'INT',
				];
		$email = Table::getInstance('email', 'Table', array());				
		$email->bind(Factory::getApplication()->input->getArray($columns));
		if($email->embed_image)
			$email->embed_image = 1;
		else
			$email->embed_image = 0;
		$email->store();
		return $email;
	}
	function getCSS()
	{
		$css = angkor_Helper::getCSS();		
		return $css;
	}
}