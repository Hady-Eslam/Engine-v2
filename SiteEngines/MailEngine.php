<?php

namespace SiteEngines;
use PHPMailer\PHPMailer\PHPMailer;
use SiteEngines\HashingEngine;
include_once _DIR_.'/SiteEngines/Mails/vendor/autoload.php';

class MailEngine{

	public $Mail;

	private $Hashing;
	private $MyEmail = 'abdoaslam000@gmail.com';

	private $Error_Found = false;

	function __construct(){
		try{
			$this->Mail = new PHPMailer();
			//Server settings
		    $this->Mail->SMTPDebug = 0;

		    
		    $this->Mail->isSMTP(true);                        // Set mailer to use SMTP
		    $this->Mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $this->Mail->SMTPAuth = true;            // Enable SMTP authentication
		    $this->Mail->Username = 'abdoaslam000@gmail.com';             // SMTP username
		    $this->Mail->Password = '0079521111';                // SMTP password
		    $this->Mail->SMTPSecure = 'tsl';  			//There is Also tsl
		    $this->Mail->Port = 587; 			//tsl uses Port 587 (TCP port to connect to)
		    									//tls on port 587

		    $this->Hashing = new HashingEngine();
		}
		catch(Exception $e){
			$this->Error_Found = true;
	    }
	}

	private function MakeMessage($Email, $MessageType){
		if ( $this->Error_Found )
			return Returns(-1, '',
				Error('Mail Error', '11', 'Error in Making Server settings') );
		try{
			$this->Mail->setFrom($this->MyEmail, 'Find House');
	    	$this->Mail->addAddress("abdoaslam000@gmail.com");

		    $this->Mail->isHTML(true);        // Set email format to HTML

		    if ( $this->Mail->send() )
		    	return Returns(1);
		    return Returns(0);
		}
		catch(Exception $e){
			if ( $MessageType == 1 )
				return Returns(-1, '', Error('Mail Error', '12',
						'Error in Making Email Sittings in Confirming Email') );
			else if ( $MessageType == 2 )
				return Returns(-1, '', Error('Mail Error', '13',
						'Error in Making Email Sittings in Forgetting Password') );
			return Returns(-1, '', Error('Mail Error', '16',
						'Error in Making Email Settings in interested Post'));
	    }
	}

	function SendMailToConfirm($Email, $Token){
	    $this->Mail->Subject = 'Confirm The Sien UP Proccess';
	    $this->Mail->Body = '<p>Please Click This Link To Complete The Proccess Of'
	    					." Sien UP </p><a href='".ConfirmUser
	    					."?E=".$this->Hashing->Hash_SignUP_Token($Email)
	    					."&T=".$this->Hashing->Hash_SignUP_Token($Token)."'>"
	    					.ConfirmUser."?E=".$this->Hashing->Hash_SignUP_Token($Email)
	    					."&T=".$this->Hashing->Hash_SignUP_Token($Token)."</a>"
	    					.'<p>Note That the Data Will Be Deleted if You Do Not'
	    					.' Complete The Process Of Sign UP in a Week Time</p>';

	    $this->Mail->AltBody = "Copy This Link In Your Browser To Complete The Proccess"
	    			." Of Sien UP ".ConfirmUser
	    			."?E=".$this->Hashing->Hash_SignUP_Token($Email)
	    			.'&T='.$this->Hashing->Hash_SignUP_Token($Token)
	    			.'<p>Note That the Data Will Be Deleted if You Do Not'
	    			.' Complete The Process Of Sign UP in a Week Time</p>';

	    return $this->MakeMessage($Email, 1);
	}

	function SendForgetPasswordMail($Email, $Token){
	    $this->Mail->Subject = 'Forget Password';
	    $this->Mail->Body = '<p>Click In This Link To Complete The Proccess Of Making'
	    			." New Password </p><a href = '".ReSetPassword
	    			."?E=".$this->Hashing->Hash_Login_Token($Email)
	    			."&T=".$this->Hashing->Hash_Login_Token($Token)."'>"
	    			.ReSetPassword."?E=".$this->Hashing->Hash_Login_Token($Email)
	    			."&T=".$this->Hashing->Hash_Login_Token($Token)."</a>";

	    $this->Mail->AltBody = "Copy This Link In Your Browser To Complete The "
	    			."Proccess Of Making New Password ".ReSetPassword
	    			."?E=".$this->Hashing->Hash_Login_Token($Email)
	    			."&T=".$this->Hashing->Hash_Login_Token($Token);
		
		return $this->MakeMessage($Email, 2);
	}

	function SendinterestedMail($Email, $ID){
		$this->Mail->Subject = 'interested Advertise';
	    $this->Mail->Body = '<p>This is New Post You May Be interested in</p>'
	    			."<a href = '".Post.$ID."'>Click Here To Go To See The Post</a>";

	    $this->Mail->AltBody="Copy This Link In Your Browser To See The Post".Post.$ID;
		
		return $this->MakeMessage($Email, 3);
	}
}