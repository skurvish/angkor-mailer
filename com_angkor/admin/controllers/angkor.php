<?php
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class AngkorControllerAngkor extends angkorController
{
	function preview(){		
		ob_clean();
		$body = Factory::getApplication()->input->get('body', '', 'RAW');				
		if(trim($body)=='')
			exit(0);
		$email = Factory::getMailer();
		$email->Body = $body;
		//$body = angkor_Helper::parsingEmailCSS($email,true); //Embed Image
		$mycss = Factory::getApplication()->input->get('mycss','','RAW');			
		
		$body = angkor_Helper::parsingEmailCSS($email,false,$mycss); //Direct Link Image
		echo $email->Body;
		exit(0);
	}
	function save()
	{
		$model = $this->getModel('angkor');
		$model->save_mail();	
		$this->redirect('index.php?option=com_angkor',Text::_('SAVE_SUCCESS')); 
	}
	function apply()
	{ 
		$model = $this->getModel('angkor');
		$email = $model->save_mail();		
		$data=array();		
		$data['result']=1;
		$data['message']=Text::_('SAVE_SUCCESS');
		$data['id']=$email->id;
		$data['body']=$email->body;
		$data['embed_image']=$email->embed_image .'-'.Factory::getApplication()->input->get('embed_image');
		ob_clean();
		echo json_encode($data);
		exit(0);
	}
	function cancel()
	{
		$app = Factory::getApplication();
		$app->redirect('index.php?option=com_angkor'); 
	}
}
?>