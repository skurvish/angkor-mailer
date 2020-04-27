<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\User\User;
use Joomla\CMS\User\UserHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

use Skurvish\Angkor\AngkorHelper;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class plgAngkorJoomla extends CMSPlugin
{
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();		
	}
	function onPlgAngkorEmailsList(&$emails){
		$joomlaemails =  array();

		$code = 'SEND_MSG_ACTIVATE';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SEND_MSG';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SEND_MSG_ADMIN_ACTIVATE_1';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SEND_MSG_ADMIN_ACTIVATE_2';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_ADMIN'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SEND_MSG_ADMIN_ACTIVATE_3';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SEND_MSG_ADMIN';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_ADMIN'),'description'=>Text::_($code.'_DESC'));
		
		$code ='USERNAME_REMINDER';		
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='PASSWORD_RESET_CONFIRMATION';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		//$code ='SEND_MSG_AUTHORIZE';
		$code ='SEND_MSG_TO_CONTACT';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_CONTACT'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SEND_COPY_MSG_TO_USER';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SEND_COPY_MSG_TO_ADMIN';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_ADMIN'),'description'=>Text::_($code.'_DESC'));
		
		$code ='ADD_NEW_USER';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='SENDARTICLE';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_OTHER'),'description'=>Text::_($code.'_DESC'));
		
		$code ='MASS_MAIL';
		$joomlaemails[]=array('code'=>$code,'title'=>Text::_($code.'_OPTION'),'to'=>Text::_('TO_USER'),'description'=>Text::_($code.'_DESC'));
		
		$emails['plg_angkor_joomla']=$joomlaemails;
	}
	function onDefaultEmail(&$data){
		$code = $data['code'];
		$lang =$data['lang'];
		$lang_code = $data['lang_code'];
		
		switch($code){
			case 'SEND_MSG_ACTIVATE':						
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_ACCOUNT_DETAILS')
									,'{name}'
									,'{sitename}'										
								); 					
				
				$data['body']=nl2br( 	sprintf(	Text::_('COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY')
										,'{name}'
										,'{sitename}'
										,'{activationurl}'
										,'{siteurl}'
										,'{username}'
										,'{password}'
									)
								); 
								
				if(trim($data['subject'])=='COM_USERS_EMAIL_ACCOUNT_DETAILS')
					$data['subject']=Text::_('ACCOUNT_DETAILS_FOR');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY')
					$data['body']=nl2br(Text::_('SEND_MSG_ACTIVATE'));
					
				break;
			case 'SEND_MSG':					
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
	
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_ACCOUNT_DETAILS')
									,'{name}'
									,'{sitename}'										
								); 					
				
				$data['body']= nl2br( 	sprintf(	Text::_('COM_USERS_EMAIL_REGISTERED_BODY')
										,'{name}'
										,'{sitename}'
										,'{siteurl}'
										,'{username}'
										,'{password}'
									)
								); 
				
				if(trim($data['subject'])=='COM_USERS_EMAIL_ACCOUNT_DETAILS')
					$data['subject']=Text::_('ACCOUNT_DETAILS_FOR');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_REGISTERED_BODY')
					$data['body']=nl2br(Text::_('SEND_MSG'));
					
				break;
			case 'SEND_MSG_ADMIN_ACTIVATE_1':						
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_ACCOUNT_DETAILS')
									,'{name}'
									,'{sitename}'										
								); 					
				
				$data['body']=nl2br( 	sprintf(	Text::_('COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY')
										,'{name}'
										,'{sitename}'
										,'{activationurl}'
										,'{siteurl}'
										,'{username}'
										,'{password}'
									)
								); 		
				if(trim($data['subject'])=='COM_USERS_EMAIL_ACCOUNT_DETAILS')
					$data['subject']=Text::_('ACCOUNT_DETAILS_FOR');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY')
					$data['body']=nl2br(Text::_('COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY'));

									
				break;
			case 'SEND_MSG_ADMIN_ACTIVATE_2':						
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
									
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_SUBJECT')
									,'{name}'
									,'{sitename}'
								); 					
				
				$data['body']= nl2br(sprintf(Text::_('COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_BODY')
									,'{sitename}'										
									,'{name} '
									,'{email}'
									,'{username}'
									,'{activationurl}'
								)
								);
				if(trim($data['subject'])=='COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_SUBJECT')
					$data['subject']=Text::_('COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_SUBJECT');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_BODY')
					$data['body']=nl2br(Text::_('COM_USERS_EMAIL_ACTIVATE_WITH_ADMIN_ACTIVATION_BODY'));						
					
				break;
			case 'SEND_MSG_ADMIN_ACTIVATE_3':						
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_SUBJECT')
									,'{name}'
									,'{sitename}'
								); 					
				
				$data['body']= nl2br(sprintf(Text::_('COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_BODY')																				
									,'{name}'
									,'{siteurl}'
									,'{username}'
									)
								);
		
				if(trim($data['subject'])=='COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_SUBJECT')
					$data['subject']=Text::_('COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_SUBJECT');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_BODY')
					$data['body']=nl2br(Text::_('COM_USERS_EMAIL_ACTIVATED_BY_ADMIN_ACTIVATION_BODY'));
					
				break;
			case 'SEND_MSG_ADMIN':
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_ACCOUNT_DETAILS')
									,'{name}'
									,'{sitename}'
								); 					
				
				$data['body']= nl2br(sprintf(Text::_('COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY')																				
									,'{name}'
									,'{username}'
									,'{sitename}'										
									)
								);
								
				if(trim($data['subject'])=='COM_USERS_EMAIL_ACCOUNT_DETAILS')
					$data['subject']=Text::_('ACCOUNT_DETAILS_FOR');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY')
					$data['body']=nl2br(Text::_('SEND_MSG_ADMIN'));
					
				break;
			case 'USERNAME_REMINDER':	
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_USERNAME_REMINDER_SUBJECT')
									,'{sitename}'
								); 					
				
				$data['body']= nl2br(sprintf(Text::_('COM_USERS_EMAIL_USERNAME_REMINDER_BODY')																				
									,'{sitename}'
									,'{username}'
									,'{siteurl}'
									)
								);
								
				if(trim($data['subject'])=='COM_USERS_EMAIL_PASSWORD_RESET_SUBJECT')
					$data['subject']=Text::_('USERNAME_REMINDER_EMAIL_TITLE');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_PASSWORD_RESET_BODY')
					$data['body']=nl2br(Text::_('USERNAME_REMINDER_EMAIL_TEXT'));		
					
				break;
			case 'PASSWORD_RESET_CONFIRMATION':
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_users',JPATH_SITE,$lang_code,true);	
				$data['subject']= sprintf(Text::_('COM_USERS_EMAIL_PASSWORD_RESET_SUBJECT')
									,'{sitename}'
								); 					
				
				$data['body']= nl2br(sprintf(Text::_('COM_USERS_EMAIL_PASSWORD_RESET_BODY')																				
									,'{username}'
									,'{token}'
									,'{siteurl}'
									,'{sitename}'																				
									)
								);
								
				if(trim($data['subject'])=='COM_USERS_EMAIL_PASSWORD_RESET_SUBJECT')
					$data['subject']=Text::_('PASSWORD_RESET_CONFIRMATION_EMAIL_TITLE');
					
				if(trim($data['body'])=='COM_USERS_EMAIL_PASSWORD_RESET_BODY')
					$data['body']=nl2br(Text::_('PASSWORD_RESET_CONFIRMATION_EMAIL_TEXT'));				
								
				break;
			/*
			case 'SEND_MSG_AUTHORIZE':
				$data['subject']=Text::_('AUTHORIZE_NEW_USER_TITLE');
				$data['body']=Text::_('AUTHORIZE_NEW_USER_TEXT');
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				break;
			*/
			case 'SEND_MSG_TO_CONTACT':
	
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_contact',JPATH_SITE,$lang_code,true);	
				$data['subject']= '{subject}';

				$data['body']= nl2br(sprintf(Text::_('COM_CONTACT_ENQUIRY_TEXT')																				
									,'{siteurl}'
									)
								).' {s_name}<br /><br />{message}';
								
							
				if(trim($data['body'])=='COM_CONTACT_ENQUIRY_TEXT')
					$data['body']=nl2br(Text::_('MSG_CONTACT_TEXT'));		
					
				break;
			case 'SEND_COPY_MSG_TO_USER':
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_contact',JPATH_SITE,$lang_code,true);	
				$data['subject']= sprintf(Text::_('COM_CONTACT_COPYSUBJECT_OF')
									,'{subject}'
								); 					
				
				$data['body']= nl2br(sprintf(Text::_('COM_CONTACT_COPYTEXT_OF')																				
									,'{r_name}'
									,'{siteurl}'										
									)
								);
								
				if(trim($data['subject'])=='COM_CONTACT_COPYSUBJECT_OF')
					$data['subject']=Text::_('COPY_EMAIL_TITLE');
					
				if(trim($data['body'])=='COM_CONTACT_COPYTEXT_OF')
					$data['body']=nl2br(Text::_('COPY_EMAIL_TEXT'));		
					
				break;
			case 'SEND_COPY_MSG_TO_ADMIN':
				$data['subject']=Text::_('EMAIL_COPY_TO_ADMIN_TITLE');
				$data['body']=Text::_('EMAIL_COPY_TO_ADMIN_TEXT');
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				break;
			case 'ADD_NEW_USER':					
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
					
				$language = Factory::getLanguage();
				$language->load('plg_user_joomla',JPATH_SITE.'/administrator',$lang_code,true);	
				
				$data['subject']= sprintf(Text::_('PLG_USER_JOOMLA_NEW_USER_EMAIL_SUBJECT')
									,'{name}'
									,'{sitename}'
								); 					
				
				$data['body']= nl2br(sprintf(Text::_('PLG_USER_JOOMLA_NEW_USER_EMAIL_BODY')																				
									,'{name}'
									,'{sitename}'
									,'{siteurl}'										
									,'{username}'			
									,'{password}'			
									)
								);
				
				if(trim($data['subject'])=='PLG_USER_JOOMLA_NEW_USER_EMAIL_SUBJECT')
					$data['subject']=Text::_('NEW_USER_MSG_TITLE');
					
				if(trim($data['body'])=='PLG_USER_JOOMLA_NEW_USER_EMAIL_BODY')
					$data['body']=nl2br(Text::_('NEW_USER_MSG_TEXT'));			
				break;
			case 'SENDARTICLE':
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
				
				$language = Factory::getLanguage();
				$language->load('com_mailto',JPATH_SITE,$lang_code,true);	
				
				$data['subject']='{subject}';
				$data['body']= nl2br(sprintf(Text::_('COM_MAILTO_EMAIL_MSG')																				
									,'{sitename}'
									,'{sender}'										
									,'{sender_email}'			
									,'{interesting_link}'			
									)
								);				
				break;
			case 'MASS_MAIL':
				$data['sender_name']=Text::_('SENDER_NAME');
				$data['sender_email']=Text::_('SENDER_EMAIL');
								
				$data['subject']='{subject}';
				$data['body']= '{body}';	
				break;
		}
	}
	
	function onSendEmail($systemEmail,$nCounter){
		$option = Factory::getApplication()->input->get('option');
		$task = Factory::getApplication()->input->get('task');
		$com_user_parameters = ComponentHelper::getParams('com_users');
	
		$data = $this->getData();
		
		$useractivation = intval($com_user_parameters->get('useractivation'));// 0 = none, 1=self, 2=admin
		if($option=='com_users') {
			switch($task){
				case 'register' :
					if(intval($nCounter)===1){ // First Email to user
						if ($useractivation===0)// No Activation
							$this->parseEmail('SEND_MSG',$systemEmail,$data);
						else if ($useractivation===1) // Self Activation
							$this->parseEmail('SEND_MSG_ACTIVATE',$systemEmail,$data);
						else if ($useractivation===2){// Admin Activation
							$this->parseEmail('SEND_MSG_ADMIN_ACTIVATE_1',$systemEmail,$data);						
						}
					}else{// Second, Third,... to Admin
						$this->parseEmail('SEND_MSG_ADMIN',$systemEmail,$data);						
					}
					break;
				case 'activate':	
					if(strpos($data['params'],'"activate":1')===false) //User confirm their email address and email admin to activate user account
						$this->parseEmail('SEND_MSG_ADMIN_ACTIVATE_2',$systemEmail,$data);				
					else // Admin activate user account and send email to user about their account.					
						$this->parseEmail('SEND_MSG_ADMIN_ACTIVATE_3',$systemEmail,$data);						
					
					//echo '<pre>';print_r($systemEmail);echo '</pre>';die();
					break;
				case 'remind':
					$this->parseEmail('USERNAME_REMINDER',$systemEmail,$data);				
					break;
				case 'request':
					$this->parseEmail('PASSWORD_RESET_CONFIRMATION',$systemEmail,$data);				
					break;
				case 'save' :
				case 'apply':
				case 'save2new':
					$this->parseEmail('ADD_NEW_USER',$systemEmail,$data);								
					break;
				case 'send':
					$this->parseEmail('MASS_MAIL',$systemEmail,$data);								
					break;				
			}
		}
		if($option=='com_swregimporter' AND $task=='import') {
			$this->parseEmail('ADD_NEW_USER',$systemEmail,$data);
		}
		if($option=='com_contact') {		
			if($task=='submit'){
				if($nCounter==1){
					$this->parseEmail('SEND_MSG_TO_CONTACT',$systemEmail,$data);		
				}			
				if(($nCounter==2 AND isset($data['contact_email_copy'])==false) OR $nCounter>=3){
					$this->parseEmail('SEND_COPY_MSG_TO_ADMIN',$systemEmail,$data);					
				}
				
				if($nCounter==2 AND isset($data['contact_email_copy'])==true){
					$this->parseEmail('SEND_COPY_MSG_TO_USER',$systemEmail,$data);					
				}	
			}
		}
		if($option=='com_mailto') {		
			if($task=='send'){
				$this->parseEmail('SENDARTICLE',$systemEmail,$data);								
			}
		}
	}
	/*
	*** WARNING *** This method is useful but need to condition properly to prevent endless loop. Should use nCounter as signal.
	* This method is used to call additional email to send out beside Joomla standard email. Example : "Send copy of message to admin"	
	*/
	function onAdditionalEmail($systemEmail,$nCounter){
		$option = Factory::getApplication()->input->get('option');
		$task = Factory::getApplication()->input->get('task');
		if($option=='com_contact') {		
			if($task=='submit'){
				$data = $this->getData();				
				if(($nCounter==1 AND isset($data['contact_email_copy'])==false) OR ($nCounter==2 AND isset($data['contact_email_copy'])==true)){
					$receiveSystemEmailUsers = $this->getReceiveSystemEmailUsers();
					
					$app	= Factory::getApplication();
					$config	= Factory::getConfig();
					
					foreach($receiveSystemEmailUsers as $receiveSystemEmailUser){
						$mail = Factory::getMailer()
									->setSender(
										array(
											$config->get('mailfrom'),
											$config->get('fromname')
										)
									)
									->addRecipient($receiveSystemEmailUser->email)
									->setSubject('')
									->setBody('');

						$mail->Send();						
					}
				}
			}
		}
	}
	function getReceiveSystemEmailUsers(){
		$db = Factory::getDBO();
		$query = "SELECT * FROM `#__users` WHERE `block`=0 AND `sendEmail`=1";
		$db->setQuery($query);
		$rows  = $db->loadObjectList();
		return $rows;
	}
	function getUserByColumn($email,$column='email'){
		$db = Factory::getDBO();
		$query = "SELECT * FROM `#__users` WHERE `{$column}`=".$db->Quote($email);		
		$db->setQuery($query);
		$row  = $db->loadObject();
		return $row;
	}
	function getData(){
		$data	= Factory::getApplication()->input->get('jform', array(), 'ARRAY');
		if(COUNT($data)==0)
			$data = Factory::getApplication()->input->get('post', array(), 'ARRAY');
		
		$option = Factory::getApplication()->input->get('option');
		if($option=='com_users'){
			$email ='';
			if(isset($data['email']))
				$email = $data['email'];

			if(isset($data['email1']))
				$email = $data['email1'];
				
			if(isset($data['password2']))
				$data['password_clear']=$data['password2'];
				
			$row  =  null;
			if($email)
				$row  = $this->getUserByColumn($email);
				
			if(Factory::getApplication()->input->get('token', '', 'STRING')){
				$row  = $this->getUserByColumn(Factory::getApplication()->input->get('token', '', 'RAW'),'activation');
			}
			
			if($row){
				foreach(get_object_vars($row) as $key=>$value){
					if(!isset($data[$key]))
						$data[$key]=$value;
				}
			}		
		}
		if($option=='com_contact'){
			$id = Factory::getApplication()->input->get('id', 0, 'INT');
			$db =  Factory::getDBO();
			$query = "SELECT * FROM `#__contact_details` WHERE `id`={$id}";
			$db->setQuery($query);
			$contact = $db->loadObject();			
			if ($contact->email_to == '' && $contact->user_id != 0) {
				$contact_user = User::getInstance($contact->user_id);
				$contact->email_to = $contact_user->get('email');
			}
			$data['contact']=$contact;		
		}
		
		$data['siteurl']=JURI::root();
		
		return $data;
	}
	function parseEmail($code,$systemEmail,$data){
		$app = Factory::getApplication();
		$lang = Factory::getApplication()->input->get('lang');
		$email = AngkorHelper::getEmail($code,$lang);
		$systemEmail->embed_image = $email['embed_image'];
		
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
				$finds[]='{email}';
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];						
				$replaces[]=AngkorHelper::convertURL($data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation']);	
				
				if(isset($data['password_clear']))
					$replaces[]=$data['password_clear'];
				else
					$replaces[]=$data['password1'];
				
									
				if($code=='SEND_MSG_ADMIN')
					$replaces[]=AngkorHelper::convertEmail($data['email']);
				else
					$replaces[]=$data['email'];
					
				if($code=='SEND_MSG_ADMIN'){
					$finds[]='{adminname}';
					$row  = $this->getUserByColumn($systemEmail->to[0][0]);
					if($row)
						$replaces[]=$row->name;
					else
						$replaces[]='';
				}
					
				break;				
			case 'SEND_MSG_ADMIN_ACTIVATE_2': // When user confirm their email address
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{activationurl}';				
				$finds[]='{email}';
				
				$user = Factory::getUser($data['id']);
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];
				$replaces[]=AngkorHelper::convertURL($data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$user->activation);
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
			case 'ADD_NEW_USER':
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{password}';
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];
				
				//-------- In case admin leave password blank, system will generate a random password
				$password_clear = '';
				if(isset($data['password_clear']))
					$password_clear = $data['password_clear'];
				if($password_clear==''){
					$email_address = '';
					if(isset($data['email']))
						$email_address = $data['email'];
					if(isset($data['email1']))
						$email_address = $data['email1'];
						
					$password_clear = UserHelper::genRandomPassword();		
					$salt = UserHelper::genRandomPassword(32);
					$crypt = UserHelper::getCryptedPassword($password_clear, $salt);
					$db = Factory::getDBO();
					$query="UPDATE `#__users` 
							SET `password`=".$db->Quote($crypt . ':' . $salt)
							." WHERE `email`=".$db->Quote($email_address);
					$db->setQuery($query);
					$db->Query();	
					$data['password_clear']=$password_clear;
				}
				//-------- End in case admin leave password blank, system will generate a random password
				
				$replaces[]=$data['password_clear'];
				break;
				
			case 'USERNAME_REMINDER':
				$finds[]='{username}';		
				
				$replaces[]=$data['username'];				
				break;
			case 'PASSWORD_RESET_CONFIRMATION':
				// Set the confirmation token.
				$token = JApplication::getHash(UserHelper::genRandomPassword());
				$salt = UserHelper::getSalt('crypt-md5');
				$hashedToken = md5($token.$salt).':'.$salt;				
				
				$db = Factory::getDBO();
				$query = "UPDATE `#__users` SET `activation`=".$db->Quote($hashedToken). ' WHERE `id`='.$data['id'];
				$db->setQuery($query);
				$db->query();
								
				$config	= Factory::getConfig();
				$mode = $config->get('force_ssl', 0) == 2 ? 1 : -1;
				$itemid = UsersHelperRoute::getLoginRoute();
				$itemid = $itemid !== null ? '&Itemid='.$itemid : '';
				$link = 'index.php?option=com_users&view=reset&layout=confirm'.$itemid;
				
				$finds[]='{name}';
				$finds[]='{username}';
				$finds[]='{token}';
				$finds[]='{siteurl}';
				
				$replaces[]=$data['name'];
				$replaces[]=$data['username'];
				$replaces[]=$token;
				$replaces[]=AngkorHelper::convertURL(Route::_($link, true, $mode));
				
				break;
			/*case 'SEND_MSG_AUTHORIZE':
				break;
			*/
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
				$replaces[]=AngkorHelper::convertEmail($data['contact_email']);
				$replaces[]=$data['contact_subject'];
				$replaces[]=$data['contact_message'];				
				$replaces[]=$data['contact']->name;
				$replaces[]=AngkorHelper::convertEmail($data['contact']->email_to);			
				
				$row  = $this->getUserByColumn($systemEmail->to[0][0]);
				if($row)
					$replaces[]=$row->name;
				else
					$replaces[]='';	
						
				break;
			case 'SENDARTICLE':
				$finds[]='{email_to}';
				$finds[]='{sender}';
				$finds[]='{sender_email}';
				$finds[]='{subject}';				
				$finds[]='{interesting_link}';
				
				$replaces[]=$data['mailto'];
				$replaces[]=$data['sender'];
				$replaces[]=$data['from'];
				$replaces[]=$data['subject'];				
				$replaces[]=MailtoHelper::validateHash(Factory::getApplication()->input->get('link', '', 'STRING'));				

				break;
			case 'MASS_MAIL':
				$finds[]='{subject}';
				$finds[]='{body}';
				
				$replaces[]=$data['subject'];
				$replaces[]=nl2br($data['message']);
				break;
			
		}
		switch($code){
			case 'SEND_MSG': // No activation
			case 'SEND_MSG_ACTIVATE': // Self activation
			case 'SEND_MSG_ADMIN_ACTIVATE_1': // admin activation		
			case 'SEND_MSG_ADMIN':
			case 'SEND_MSG_ADMIN_ACTIVATE_2': // When user confirm their email address
			case 'SEND_MSG_ADMIN_ACTIVATE_3': // When admin activate user address
			case 'ADD_NEW_USER':
				AngkorHelper::findreplaceuserid($data['email'],$finds,$replaces);
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
		$finds[]='{loginurl}'; 
		
		$uri = Factory::getURI();
		$replaces[]=$app->getCfg('fromname');
		$replaces[]=$app->getCfg('mailfrom');
		$replaces[]= $app->getCfg('sitename');
		$replaces[]= AngkorHelper::convertURL(Uri::root());		
		$replaces[]= AngkorHelper::convertURL($uri->toString(array('scheme','host')).Route::_('index.php?option=com_users&view=login'));	
				
		$email['subject']=str_replace($finds,$replaces,$email['subject']);
		$email['body']=str_replace($finds,$replaces,$email['body']);
		
		//$email['body'] = AngkorHelper::convertBodyImage_Href($email['body']);
		
		$email['sender_name']=str_replace($finds,$replaces,$email['sender_name']);
		$email['sender_email']=str_replace($finds,$replaces,$email['sender_email']);		
		
		$systemEmail->From=$email['sender_email'];
		$systemEmail->FromName=$email['sender_name'];
		$systemEmail->Sender=$email['sender_email'];
		$systemEmail->Subject=$email['subject'];
		$systemEmail->Body=$email['body'];	
	}	
}
