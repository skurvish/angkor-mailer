<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Mail\Mail;
use Joomla\CMS\Mail\MailHelper;
use Joomla\CMS\Plugin\PluginHelper;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class plgSystemAngkor extends CMSPlugin
{
	function __construct(&$subject, $config){
		parent::__construct($subject, $config);
	}
	/*
	*	Render admin input css as css file for <link ...>
	*/
	public function onafterRoute(){
		if(!$this->isCorrectPage())
			return false;
			
		if(Factory::getApplication()->input->get('angkorcss', 0, 'INT')){
			$css = $this->getCSS();
			ob_clean();
			header('Content-Type: text/css');						
			echo $css->css;
			exit(0);
		}
	}	
	/*
	* Override Editor CSS template file
	*/
	public function onAfterRender(){
		if(!$this->isCorrectPage())
			return false;
		$body = JResponse::getBody();
		$bodys= explode("\n",$body);
		
		$replace='content_css : "'.JURI::root().'administrator/index.php?option=com_angkor&angkorcss=1",';
		foreach($bodys as $b){
			if( substr(trim($b),0,15)=='content_css : "' OR substr(trim($b),0,14)=='content_css: "'){				
				$body = str_replace($b,$replace,$body);
			}
		}
		JResponse::setBody($body);	
	}
	/*
	* Override Joomla standard Mail with angkorMailer which extends Mail class
	*/
	function onAfterInitialise(){		
		jimport('joomla.mail.mail');
		Factory::$mailer = new angkorMailer;

		$conf = Factory::getConfig();
		$smtpauth = ($conf->get('smtpauth') == 0) ? null : 1;
		$smtpuser = $conf->get('smtpuser');
		$smtppass = $conf->get('smtppass');
		$smtphost = $conf->get('smtphost');
		$smtpsecure = $conf->get('smtpsecure');
		$smtpport = $conf->get('smtpport');
		$mailfrom = $conf->get('mailfrom');
		$fromname = $conf->get('fromname');
		$mailer = $conf->get('mailer');

		// Set default sender without Reply-to
		Factory::$mailer->SetFrom(MailHelper::cleanLine($mailfrom), MailHelper::cleanLine($fromname), 0);

		// Default mailer is to use PHP's mail function
		switch ($mailer)
		{
			case 'smtp':
				Factory::$mailer->useSMTP($smtpauth, $smtphost, $smtpuser, $smtppass, $smtpsecure, $smtpport);
				break;

			case 'sendmail':
				Factory::$mailer->IsSendmail();
				break;

			default:
				Factory::$mailer->IsMail();
				break;
		}
	}
	/*
	* Get Admin defined CSS 
	*/
	function getCSS(){
		$db =Factory::getDBO();
		$q="SELECT * 
			FROM `#__angkor_css`";
		$db->setQuery($q);				
		return $db->loadObject();	
	}
	/*
	* Check if the plugin should process or leave
	*/
	function isCorrectPage(){
		$app = Factory::getApplication();
		if(!$app->isAdmin())
			return false;
		
		$option = Factory::getApplication()->input->get('option');	
		if($option=='com_angkor')
			return true;
		return false;
	}
}

class angkorMailer extends Mail{
	public $to           = array();
	function getTo(){
		return parent::$to;
	}
	function send(){		
		static $nCounter;
		$nCounter++;
		
		PluginHelper::importPlugin('angkor');		
		$emails = array();
		$results = Factory::getApplication()->triggerEvent('onSendEmail', array (&$this,$nCounter));
		
		angkor_Helper::parsingEmailCSS($this,$this->embed_image);
		
		if($this->embed_image)
			$this->AltBody = 'Please use Email application which supports HTML Email to view the email';
		else
			$this->AltBody = angkor_Helper::getAltBody($this->Body);
			
		$return = parent::Send();			
		
		$results = Factory::getApplication()->triggerEvent('onAdditionalEmail', array (&$this,$nCounter));
		
		return $return;
	}
}