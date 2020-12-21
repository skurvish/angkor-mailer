<?php

namespace Skurvish\Angkor;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Plugin\PluginHelper;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/* Include the latest emogrifier */
require_once(JPATH_ADMINISTRATOR.'/components/com_angkor/helper/vendor/autoload.php');
use Pelago\Emogrifier\CssInliner;;

class AngkorHelper
{
	
	function get_angkor_email($code,$data)
	{
		$language = Factory::getLanguage();
		$select_language = self::get_selected_language($language->get('tag'));
		$email = self::parse_email($code,$select_language->lang_id,$data);
		return $email;
	}
	function get_email($code,$lang_id)
	{
		$db =Factory::getDBO();
		$q="Select * 
			From `#__angkor_emails` 
			WHERE `code`='" . $code . "'
			AND `lang_id`='".$lang_id."'";
		$db->setQuery($q);	
		return $db->loadObject();
	}
	function parse_email($code,$lang_id,$data)
	{
		$app		= Factory::getApplication();
		$email = self::get_email($code,$lang_id);
		if(!$email)
			return false;
		$finds = array();
		$replaces = array();
		
		switch($code)
		{
			case 'SEND_MSG': // No activation
			case 'SEND_MSG_ACTIVATE': // Self activation
			case 'SEND_MSG_ADMIN_ACTIVATE_1': // admin activation		
			case 'SEND_MSG_ADMIN':
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{activationurl}';
				$finds[]='{password}';
				$finds[]='{adminname}';
				$finds[]='{email}';
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];						
				$replaces[]=self::convertURL($data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation']);	
				$replaces[]=$data['password_clear'];
				
				if(isset($data['adminname']))		
					$replaces[]=$data['adminname'];
				else
					$replaces[]='';
					
				if($code=='SEND_MSG_ADMIN')
					$replaces[]=self::convertEmail($data['email']);
				else
					$replaces[]=$data['email'];
					
				break;				
			case 'SEND_MSG_ADMIN_ACTIVATE_2': // When user confirm their email address
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{activationurl}';				
				$finds[]='{email}';
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];
				$replaces[]=self::convertURL($data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation']);
				$replaces[]=$data['email'];
				
				break;
			case 'SEND_MSG_ADMIN_ACTIVATE_3': // When admin activate user address
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{email}';
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];			
				$replaces[]=$data['email'];
				break;
			case 'USERNAME_REMINDER':
				$finds[]='{username}';
				$finds[]='{login_url}';
				$finds[]='{siteurl}';
				
				$replaces[]=$data['username'];
				$replaces[]=self::convertURL($data['link_text']);				
				$replaces[]=self::convertURL($data['link_text']);								
				break;
			case 'PASSWORD_RESET_CONFIRMATION':
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{token}';
				$finds[]='{login_url}';
				$finds[]='{siteurl}';				
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];
				$replaces[]=$data['token'];
				$replaces[]=self::convertURL($data['link_text']);	
				$replaces[]=self::convertURL($data['link_text']);	
				break;
			case 'SEND_MSG_AUTHORIZE':
				break;
			case 'SEND_MSG_TO_CONTACT':
			case 'SEND_COPY_MSG_TO_USER':
			case 'SEND_COPY_MSG_TO_ADMIN':
				$finds[]='{s_name}';
				$finds[]='{s_email}';
				$finds[]='{subject}';
				$finds[]='{message}';				
				$finds[]='{r_name}';
				$finds[]='{r_email}';
				$finds[]='{adminname}';
				
				$replaces[]=$data['contact_name'];
				$replaces[]=self::convertEmail($data['contact_email']);
				$replaces[]=$data['contact_subject'];
				$replaces[]=$data['contact_message'];				
				$replaces[]=$data['contact']->name;
				$replaces[]=self::convertEmail($data['contact']->email_to);			
								
				if(isset($data['adminname']))
					$replaces[]=$data['adminname'];
				else
					$replaces[]='';								
				break;
			case 'ADD_NEW_USER':
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{password}';
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];
				$replaces[]=$data['password_clear'];
				break;
		}
		switch($code)
		{
			case 'SEND_MSG': // No activation
			case 'SEND_MSG_ACTIVATE': // Self activation
			case 'SEND_MSG_ADMIN_ACTIVATE_1': // admin activation		
			case 'SEND_MSG_ADMIN':
			case 'SEND_MSG_ADMIN_ACTIVATE_2': // When user confirm their email address
			case 'SEND_MSG_ADMIN_ACTIVATE_3': // When admin activate user address
			case 'ADD_NEW_USER':
				self::findreplaceuserid($data['email'],$finds,$replaces);
				break;
			case 'SEND_MSG_TO_CONTACT':
			case 'SEND_COPY_MSG_TO_USER':
			case 'SEND_COPY_MSG_TO_ADMIN':
				$finds[]='{user_id}';
				$finds[]='{contact_id}';
				$replaces[]= $data['contact']->user_id;
				$replaces[]= $data['contact']->id;
				break;
		}
		
		$finds[]='{sendername}';
		$finds[]='{senderemail}';		
		$finds[]='{sitename}';
		$finds[]='{siteurl}'; 
		
		$replaces[]=$app->getCfg('fromname');
		$replaces[]=$app->getCfg('mailfrom');
		$replaces[]= $app->getCfg('sitename');
		$replaces[]= self::convertURL(Uri::root());		
				
		$email->subject=str_replace($finds,$replaces,$email->subject);
		$email->body=str_replace($finds,$replaces,$email->body);
		$email->body = self::convertBodyImage_Href($email->body);
		
		$email->sender_name=str_replace($finds,$replaces,$email->sender_name);
		$email->sender_email=str_replace($finds,$replaces,$email->sender_email);
		//echo '<hr /><pre>'; 	print_r($data); echo '</pre>'; 		echo '<hr /><pre>'; 	print_r($email); echo '</pre>'; 		stop();
		return $email;
	}
	function get_selected_language($tag)
	{
		$languages	= LanguageHelper::getLanguages();
		foreach($languages as $language)
		{
			if($language->lang_code==$tag)
				return $language;
		}		
	}
	function get_all_system_users()
	{
		$db =& Factory::getDBO();
		$query = "SELECT * FROM `#__users` 
				WHERE `block`=0 
				AND `sendEmail`=1";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}
	function getAltBody($body)
	{		
		$finds=array();
		$replaces=array();
		$finds[]='<br';		$replaces[]="\n<br";
		$finds[]='<p';		$replaces[]="\n<p";
		$finds[]='</p';		$replaces[]="\n</p";
		$finds[]='<div';		$replaces[]="\n<div";
		$finds[]='</div';		$replaces[]="\n</div";
		$finds[]='<hr';		$replaces[]="_____________________________________________________________<hr";
		$finds[]='<h';		$replaces[]="\n<h";
		$finds[]='<\h';		$replaces[]="\n</h";
		$altbody = str_replace($finds,$replaces,$body);		
		$altbody = strip_tags($altbody);
		while(substr($altbody,0,1)=="\n")
		{
			$altbody = substr($altbody,1);
		}
		return $altbody;
	}
	function convertURL($url)
	{
		$linkable_url = '<a href="'.$url.'" title="'.$url.'">'.$url.'</a>';
		return $linkable_url ;
	}
	function convertEmail($email)
	{
		$linkable_url = '<a href="mailto:'.$email.'" title="'.$email.'">'.$email.'</a>';
		return $linkable_url ;
	}

	function findreplaceuserid($email,&$finds,&$replaces)
	{
		$finds[]='{user_id}';
		$replaces[]=self::getUserInfobyEmail($email,'id');
	}
	function getUserInfobyEmail($email,$field_name)
	{
		$db = Factory::getDBO();
		$query = "SELECT `{$field_name}` 
				FROM `#__users` 
				WHERE `email`=". $db->Quote($email);
		$db->setQuery($query);
		return $db->loadResult();
	}
	function convertBodyImage_Href($message_body)
	{
		$tobereplaced = array();	$replacedby=array();
		$uri = Factory::getURI();	
		$site_url = $uri->toString(array('scheme','host', 'port')).'/';		
		
		@preg_match_all('/<a[^>]+>/i',$message_body, $matches);
		if($matches)
		{
			foreach( $matches[0] as $matche)
			{
				preg_match_all('/(href)=("[^"]*")/i',$matche, $href);			
				if(isset($href[2][0]))
				{
					if($href[2][0]!='')
					{
						$a_href=str_replace(array('"',"'"),array('',''),$href[2][0]);
						
						if(substr($a_href,0,4)!='cid:'){
							if(strtolower(substr($a_href,0,4))=='www.')
							{
								$tobereplaced[]=$href[0][0];							
								$url ='http://'.$a_href;
								$replacedby[]='href="'.$url.'"';
							}	
							elseif(strtolower(substr($a_href,0,7))!='http://' AND strtolower(substr($a_href,0,8))!='https://')
							{
								$tobereplaced[]=$href[0][0];	
								if(trim($a_href)=='index.php' OR trim($a_href)=='/')
									$url =$uri->root();					
								else {
									$route = Route::_($a_href);
									/* Remove any trailing and leading slashes in the two parts, certain cases we have both */
									$site_url = trim($site_url, '/');
									$route = ltrim($route,'/');
									$url = $site_url . '/' . $route;
								}
								$replacedby[]='href="'.$url.'"';
							}	
						}						
					}
				}
			}
		}
		@preg_match_all('/<img[^>]+>/i',$message_body, $matches);
		if($matches)
		{
			foreach( $matches[0] as $matche)
			{
				preg_match_all('/(src)=("[^"]*")/i',$matche, $src);			
				if(isset($src[2][0]))
				{
					if($src[2][0]!='')
					{
						$img_src=str_replace(array('"',"'"),array('',''),$src[2][0]);
						
						if(substr($img_src,0,4)!='cid:'){
							if(strtolower(substr($img_src,0,7))!='http://' AND strtolower(substr($img_src,0,8))!='https://')
							{
								$tobereplaced[]=$src[0][0];
								
								$url = str_replace(' ','%20',$uri->root().$img_src);
								$replacedby[]='src="'.$url.'"';
							}
						}
					}
				}
			}
		}		

		return str_replace($tobereplaced,$replacedby,$message_body);
	}	
	function getEmailsList(){
		PluginHelper::importPlugin('angkor');		
		$emails = array();		
		//$results = $Factory::getApplication()->triggerEvent('onEmailsList', array ($emails));
		$angkorPlgs = PluginHelper::getPlugin('angkor');
		Factory::getApplication()->triggerEvent('onPlgAngkorEmailsList', array(&$emails));

		return $emails;		
	}
	function loadAssets(){
		$document = Factory::getDocument();
		$url = Uri::root().'administrator/components/com_angkor/assets/css/angkor.css';
		$document->addStyleSheet($url);
		
//		$view = Factory::getApplication()->input->get('view','angkor', 'STRING');
		//if($view=='css'){
			$url = Uri::root().'administrator/components/com_angkor/assets/codemirror/codemirror.js';			
			$document->addScript($url);
			
			$url = Uri::root().'administrator/components/com_angkor/assets/codemirror/css.js';			
			$document->addScript($url);
			
			$url = Uri::root().'administrator/components/com_angkor/assets/codemirror/codemirror.css';			
			$document->addStyleSheet($url);
	//	}
		//else{		
		  
			$url = '//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js';
			$document->addScript($url);
			
			$url = Uri::root().'media/jui/js/jquery.min.js';
			$document->addScript($url);
			$url = Uri::root().'media/jui/js/jquery-noconflict.js';
			$document->addScript($url);
			
			$url = Uri::root().'administrator/components/com_angkor/assets/js/angkor.js';
			$document->addScript($url);	
		//}
	}
	function getAvailableFieldParameters($code)
	{
		if($code=='')
			$code=Factory::getApplication()->input->get('code', '', 'STRING');
			
		if($code)
		{
			$dbFields =Factory::getDBO();
			$q="Select * 
				From `#__angkor_email_fields` 
				WHERE `code`='" . $code . "'";
			$fields=array();
			$dbFields->setQuery($q);				
			$rows=$dbFields->loadObjectList();				
			
			$available_fields = array();
			foreach($rows as $row){
				$available_fields[]=$row->field_name;
			}
			
			PluginHelper::importPlugin('angkor');		
			$results = Factory::getApplication()->triggerEvent('onDynamicAvailableFields', array ($code,&$available_fields));
			
			foreach($available_fields as $field){
				$fields[]= '<a href="javascript:jInsertEditorText(\''. $field.'\',\'body\')">' . $field  . '</a>';
			}
			return implode(' , ',$fields);
		}
	}
	function getCSS()
	{
		$db =Factory::getDBO();
		$q="SELECT * 
			FROM `#__angkor_css`";
		$db->setQuery($q);				
		return $db->loadObject();			
	}
	function getLanguageTag($sefCode){ // nl -> nl-NL or en -> en-GB
		$languages	= LanguageHelper::getLanguages();	
		foreach($languages as $language){
			if($language->sef==$sefCode)
				return $language->lang_code;
		}
		return '';
	}
	function getLanguageCode($tag){ // nl -> nl-NL or en -> en-GB
		$languages	= LanguageHelper::getLanguages();	
		foreach($languages as $language){
			if($language->lang_code==$tag)
				return $language->sef ;
		}
		return '';
	}
	
	function getEmail($code,$lang){
		if($lang==''){
			$language = Factory::getLanguage();
			$lang = self::getLanguageCode($language->getTag());
		}
		$db = Factory::getDBO();
		$query = "SELECT * FROM `#__angkor_emails` 
				WHERE `code`=".$db->Quote($code)
				. " AND `lang`=".$db->Quote($lang);
		$db->setQuery($query);
		$email = $db->loadObject();
		
		$data=array();		
		$data['code']=$code;
		$data['lang']=$lang;
		$data['lang_code']=self::getLanguageTag($lang);
		
		$data['id']='';
		$data['embed_image']=false;
		if($email){			
			$data['id']=$email->id;	
			$data['sender_name']=$email->sender_name;
			$data['sender_email']=$email->sender_email;
			$data['subject']=$email->subject;
			$data['body']=$email->body;
			if($email->embed_image)
				$data['embed_image']=true;
		}else{		
			PluginHelper::importPlugin('angkor');		
			$results = Factory::getApplication()->triggerEvent('onDefaultEmail', array (&$data));
		}
		return $data;
	}
	function parsingEmailCSS($email,$embed_image=false,$css_content=''){
		
		if($css_content==''){
			$css = self::getCSS();		
			if (!empty($css)) {
				$css_content = $css->css;
			}
		}
		$email->Body = CssInliner::fromHtml($email->Body)->inlineCss($css_content)->render();;				
		
		if($embed_image AND method_exists($email,'MsgHTML')){	
			$email->MsgHTML($email->Body,JPATH_SITE);
		}
		$email->Body = self::convertBodyImage_Href($email->Body);				
	}
}
?>
