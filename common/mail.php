<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'thirdParty/PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'thirdParty/PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'thirdParty/PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';

class mailer{
	public $mailParams;
	
	public function __construct($mailParams){
		$this->mailParams = $mailParams;
	}
	
	public function sendMailer(){
		
		$mail = new PHPMailer();
		
		$this->generate_mail_system($mail);
		
		$this->get_recipients($mail);
		
		$this->get_sender($mail);
		
		if(count($this->mailParams['replyto_arr'])>0){
			$this->get_replyto($mail);
		}
		
		if(count($this->mailParams['cc_arr'])>0){
			$this->get_cc($mail);
		}
		
		if(count($this->mailParams['bcc_arr'])>0){
			$this->get_bcc($mail);
		}
		
		if(count($this->mailParams['attachment_arr'])>0){
			$this->get_attachments($mail);
		}
		
		$mail->Subject = $this->mailParams['subject'];
		$content = $this->mailParams['content'];
		
		$mail->MsgHTML($content); 
		
		if(!$mail->Send()) {
		  return 0;
		} else {
		  return 1;
		}
	}
	
	public function generate_mail_system($mail){
		$mail_system_params_json = $this->mailParams['mailSystemArr_json'];
		$mail_system_params = json_decode($mail_system_params_json,true);
		extract($mail_system_params);
		
		$mail->IsSMTP();
		$mail->Mailer = $Mailer;

		$mail->SMTPDebug  = $SMTPDebug;  
		$mail->SMTPAuth   = $SMTPAuth;
		$mail->SMTPSecure = $SMTPSecure;
		$mail->Port       = $Port;
		$mail->Host       = $Host;
		$mail->Username   = $Username;
		$mail->Password   = $Password;

		$mail->IsHTML($IsHTML);
	}
	
	public function get_recipients($mail){
		$recipient_arr = $this->mailParams['recipient_arr'];
		
		for($i=0;$i<count($recipient_arr);$i++){
			$mail->AddAddress($recipient_arr[$i]['address'], $recipient_arr[$i]['name']);
		}
	}
	
	public function get_sender($mail){
		$mail->SetFrom($this->mailParams['SetFromAddress'], $this->mailParams['SetFromName']);
	}
	
	public function get_replyto($mail){
		$replyto_arr = $this->mailParams['replyto_arr'];
		for($i=0;$i<count($replyto_arr);$i++){
			$mail->AddReplyTo($replyto_arr[$i]['address'], $replyto_arr[$i]['name']);
		}
	}
	
	public function get_cc($mail){
		$cc_arr = $this->mailParams['cc_arr'];
		for($i=0;$i<count($cc_arr);$i++){
			$mail->AddCC($cc_arr[$i]['address'], $cc_arr[$i]['name']);
		}
	}
	
	public function get_bcc($mail){
		$bcc_arr = $this->mailParams['bcc_arr'];
		for($i=0;$i<count($bcc_arr);$i++){
			$mail->addBCC($bcc_arr[$i]['address'], $bcc_arr[$i]['name']);
		}
	}
	
	public function get_attachments($mail){
		$attachment_arr = $this->mailParams['attachment_arr'];
		for($i=0;$i<count($attachment_arr);$i++){
			$mail->addAttachment($attachment_arr[$i]['path'], $attachment_arr[$i]['name']);
		}
	}
}

