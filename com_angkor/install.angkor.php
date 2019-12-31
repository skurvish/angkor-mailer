<?php
use Joomla\CMS\Factory;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class angkorInstaller{
	function getLangSEFbyLangID($lang_id){
		$db = Factory::getDBO();
		$query ="SELECT `sef` 
				FROM `#__languages` 
				WHERE `lang_id`={$lang_id}" ;
		$db->setQuery($query);
		return $db->loadResult();
	}
	function getExistingEmail($code,$lang){
		$db = Factory::getDBO();
		$query ="SELECT COUNT(*) 
				FROM `#__angkor_emails` 
				WHERE `code`=" . $db->Quote($code)
				. " AND `lang`=" . $db->Quote($lang);
		$db->setQuery($query);
		return ($db->loadResult()>0);
	}
}
function com_install()
{
	$db = Factory::getDBO();
	$old_email_table = $db->replacePrefix('#__nu_emailmsg');
	$all_tables = $db->getTableList();

	if(array_search($old_email_table,$all_tables)){	
		$query ="SELECT * FROM `{$old_email_table}`";
		$db->setQuery($query);
		$emails = $db->loadObjectList();
		if($emails){
			foreach($emails as $email){			
				$code = $email->code;							
				$lang = angkorInstaller::getLangSEFbyLangID($email->lang_id);
				
				if(angkorInstaller::getExistingEmail($code,$lang)==false){ // If email is not exists
					$subject = $email->subject;
					$body = $email->body;			
					$sender_name = $email->sender_name;
					$sender_email = $email->sender_email;
					$embed_image = 1;
					$query ="INSERT INTO `#__angkor_emails`
							SET `code`=".$db->Quote($code)
							. ", `subject`=".$db->Quote($subject)
							. ", `body`=".$db->Quote($body)
							. ", `sender_name`=".$db->Quote($sender_name)
							. ", `sender_email`=".$db->Quote($sender_email)
							. ", `embed_image`=".$db->Quote($embed_image)
							. ", `lang`=".$db->Quote($lang);
					$db->setQuery($query);
					$db->Query();
				}
			}
			$query = "DROP TABLE IF EXISTS`#__nu_emailmsg`";
			$db->setQuery($query);
			$db->Query();
			
			$query = "DROP TABLE IF EXISTS `#__nu_emailmsg_fields`";
			$db->setQuery($query);
			$db->Query();
		}
	}
}