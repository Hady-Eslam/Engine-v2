<?php

namespace SiteEngines;

class HashingEngine{

	// We Get Encryption Key From This Code
	// base64_encode(openssl_random_pseudo_bytes(32));
	private $USER_ENCRYPTION_KEY = 'qO3+E0bJcmUvi5uCR+MaKEDzQ3JnqYi73dhdZLyMQMo=';
	private $USER_HASH_LEN = 2;

	private $WAITING_ENCRYPTION_KEY = 'GDmdMAdhgvYKYtvRXPhtk6u9XXMmaFgb8gk+9Fu6jPA=';
	private $WAITING_USER_HASH_LEN = 4;

	private $SESSION_ENCRYPTION_KEY = '/lvBsOm3BoHJjKUZ8v4Dlwl27rIrDB3ttSEb7lBnTs8=';
	private $SESSION_HASH_LEN = 6;

	private $SIGNUP_ENCRYPTION_KEY = 'uxBl14mO5rH5FJJVa1FeWrD+YL1ar8o5y26LLENyAjk=';
	private $SIGNUP_TOKEN_HASH_LEN = 8;

	private $LOGIN_ENCRYPTION_KEY = '18eDmSKmEHA8a7QmXMSbxHIvmu1AUnhSKCvXvHLFjrE=';
	private $LOGIN_TOKEN_HASH_LEN = 10;

	private $POSTS_ENCRYPTION_KEY = 'mp65YCSmzoRPG88nkKmyKn7zcOPF05dnmayjB96S+Do=';
	private $POSTS_HASH_LEN = 12;

	private $INTERESTED_ENCRYPTION_KEY = 'TeHYYDuILuRirbNAuidwRYX06pcJA829xQmu94TsPMw=';
	private $INTERESTED_HASH_LEN = 14;

	private $COMMENTS_ENCRYPTION_KEY = '2xnZvx7O2RBviwrjZXlmcc1R7NTZc2KimG1kZwD4UFk=';
	private $COMMENTS_HASH_LEN = 16;

	private $LIKE_DISLIKE_ENCRYPTION_KEY = 'wifDEkEDkhwYG4z6XYhHuEXxzerSGL+AgeBKFMl6MvM=';
	private $LIKE_DISLIKE_HASH_LEN = 18;

	private $NOTIFICATIONS_ENCRYPTION_KEY = 'kMPXEK7P2xxhQIMi+KaWVMXvhitSpuBMN4MXcWYd8ZQ=';
	private $NOTIFICATIONS_HASH_LEN = 20;

	private $MESSAGES_ENCRYPTION_KEY = 'UVQnY+hkhYLLV/1o9R/jKbGNoG1bSW76b3qXOvnerzo=';
	private $MESSAGES_HASH_LEN = 22;


	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////

	private function Encrypt_Data($Data, $Key){

		$encryption_key = base64_decode($Key);
	    // Generate an initialization vector
	    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
	    $encrypted = openssl_encrypt($Data, 'aes-256-cbc', $encryption_key, 0, $iv);
	    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
	    return base64_encode($encrypted . '::' . $iv);
	}

	// Hash
	function Hash_Users($User){
		//return $this->Encrypt_Data('MY'.$User, $this->USER_ENCRYPTION_KEY);
		return 'MY'.$User;
	}

	function Hash_WaitingUsers($User){
		//return $this->Encrypt_Data('MYNA'.$User, $this->WAITING_ENCRYPTION_KEY);
		return 'MYNA'.$User;
	}

	function Hash_Session($Session){
		//return $this->Encrypt_Data('MYNAME'.$Session, $this->SESSION_ENCRYPTION_KEY);
		return 'MYNAME'.$Session;
	}

	function Hash_SignUP_Token($Token){
		//return $this->Encrypt_Data('MYNAMEHA'.$Token, $this->SIGNUP_ENCRYPTION_KEY);
		return 'MYNAMEHA'.$Token;

	}

	function Hash_Login_Token($Token){
		//return $this->Encrypt_Data('MYNAMEHADY'.$Token, $this->LOGIN_ENCRYPTION_KEY);
		return 'MYNAMEHADY'.$Token;
	}

	function Hash_POSTS($POST){
		//return $this->Encrypt_Data('MYNAMEHADYES'.$POST, $this->POSTS_ENCRYPTION_KEY);
		return 'MYNAMEHADYES'.$POST;
	}

	function Hash_interested($interested){
		/*return $this->Encrypt_Data('MYNAMEHADYESLA'.$interested,
				$this->INTERESTED_ENCRYPTION_KEY);*/
		return 'MYNAMEHADYESLA'.$interested;
	}

	function Hash_Comments($Comments){
		/*return $this->Encrypt_Data('MYNAMEHADYESLAMM'.$Comments,
			$this->COMMENTS_ENCRYPTION_KEY);*/
		return 'MYNAMEHADYESLAMM'.$Comments;
	}

	function Hash_Like_DisLike($Like_DisLike){
		/*return $this->Encrypt_Data('MYNAMEHADYESLAMMOH'.$Like_DisLike,
			$this->LIKE_DISLIKE_ENCRYPTION_KEY);*/
		return 'MYNAMEHADYESLAMMOH'.$Like_DisLike;
	}

	function Hash_Notifications($Notification){
		/*return $this->Encrypt_Data('MYNAMEHADYESLAMMOHAM'.$Notification,
			$this->NOTIFICATIONS_ENCRYPTION_KEY);*/
		return 'MYNAMEHADYESLAMMOHAM'.$Notification;
	}

	function Hash_Messages($Message){
		/*return $this->Encrypt_Data('MYNAMEHADYESLAMMOHAMME'.$Message,
			$this->MESSAGES_ENCRYPTION_KEY);*/
		return 'MYNAMEHADYESLAMMOHAMME'.$Message;
	}


	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////

	private function Decrypt_Data($Data, $Key){
		// Remove the base64 encoding from our key
    	$encryption_key = base64_decode($Key);
    	// To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    	list($encrypted_data, $iv) = explode('::', base64_decode($Data), 2);
    	return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
	}

	// Get Hashed
	private function GetString($String, $LEN, $Location, $Key){
		try{
			if ( strlen($String) < $LEN )
				return Returns(-1 , '', Error('Hashing Error', '8',
							"Length is Short, Can't Hashing") );
			//return Returns(1 , substr($this->Decrypt_Data($String, $Key), $LEN));
			return Returns(1 , substr($String, $LEN));
		}
		catch(Exception $e){
			return Returns(-1,'',Error('Hashing Error','14',"Can't Get Object Hashed"));
		}
	}

	function Get_Hashed_Users($User){
		return $this->GetString($User, $this->USER_HASH_LEN, 'User',
				$this->USER_ENCRYPTION_KEY);
	}

	function Get_Hashed_WaitingUsers($WaitingUser){
		return $this->GetString($WaitingUser, $this->WAITING_USER_HASH_LEN,
					'Waiting User', $this->WAITING_ENCRYPTION_KEY);
	}

	function Get_Hashed_Session($Session){
		return $this->GetString($Session, $this->SESSION_HASH_LEN, 'Session',
				$this->SESSION_ENCRYPTION_KEY);
	}

	function Get_Hashed_SignUP_Token($Token){
		return $this->GetString($Token, $this->SIGNUP_TOKEN_HASH_LEN, 'Sign UP Token',
				$this->SIGNUP_ENCRYPTION_KEY);
	}

	function Get_Hashed_Login_Token($Token){
		return $this->GetString($Token, $this->LOGIN_TOKEN_HASH_LEN, 'Log in Token',
				$this->LOGIN_ENCRYPTION_KEY);
	}

	function Get_Hashed_POSTS($POST){
		return $this->GetString($POST, $this->POSTS_HASH_LEN, 'POSTS',
				$this->POSTS_ENCRYPTION_KEY);
	}

	function Get_Hashed_interested($interested){
		return $this->GetString($interested, $this->INTERESTED_HASH_LEN, 'interested',
				$this->INTERESTED_ENCRYPTION_KEY);
	}

	function Get_Hashed_Comments($Comments){
		return $this->GetString($Comments, $this->COMMENTS_HASH_LEN, 'Comments',
				$this->COMMENTS_ENCRYPTION_KEY);
	}

	function Get_Hashed_Like_DisLike($Like_DisLike){
		return $this->GetString($Like_DisLike, $this->LIKE_DISLIKE_HASH_LEN,
				'Like DisLike', $this->LIKE_DISLIKE_ENCRYPTION_KEY);
	}

	function Get_Hashed_Notifications($Notification){
		return $this->GetString($Notification, $this->NOTIFICATIONS_HASH_LEN,
				'Notification', $this->NOTIFICATIONS_ENCRYPTION_KEY);
	}

	function Get_Hashed_Messages($Messages){
		return $this->GetString($Messages, $this->MESSAGES_HASH_LEN,
				'Messages', $this->MESSAGES_ENCRYPTION_KEY);
	}

	// Get Data From Hashing
	/*
		Type
		Key
		Data
		Default
	*/
	function Get_Data_From_Hashing($Data, $Function = ''){
		foreach ($Data as $key => $Value) {
			$Result = NULL;

			if ( $Value['Type'] == 'User' )
				$Result = $this->Get_Hashed_Users($Value['Data']);
			else if ( $Value['Type'] == 'Waiting_User' )
				$Result = $this->Get_Hashed_WaitingUsers($Value['Data']);
			else if ( $Value['Type'] == 'Session' )
				$Result = $this->Get_Hashed_Session($Value['Data']);
			else if ( $Value['Type'] == 'SignUP_Token' )
				$Result = $this->Get_Hashed_SignUP_Token($Value['Data']);
			else if ( $Value['Type'] == 'Login_Token' )
				$Result = $this->Get_Hashed_Login_Token($Value['Data']);
			else if ( $Value['Type'] == 'POSTS' )
				$Result = $this->Get_Hashed_POSTS($Value['Data']);
			else if ( $Value['Type'] == 'interested' )
				$Result = $this->Get_Hashed_interested($Value['Data']);
			else if ( $Value['Type'] == 'Comments' )
				$Result = $this->Get_Hashed_Comments($Value['Data']);
			else if ( $Value['Type'] == 'Like_DisLike' )
				$Result = $this->Get_Hashed_Like_DisLike($Value['Data']);
			else if ( $Value['Type'] == 'Notifications' )
				$Result = $this->Get_Hashed_Notifications($Value['Data']);
			else if ( $Value['Type'] == 'Messages' )
				$Result = $this->Get_Hashed_Messages($Value['Data']);
			else{
				$GLOBALS[ $Value['Key'] ] = $Value['Data'];
				continue;
			}
			
			if ( $Result->Result == -1 )
				if ( isset($Value['Default']) )
					$GLOBALS[ $Value['Key'] ] = $Value['Default'];
				else
					$this->Call_Function($Function);
			else
				$GLOBALS[ $Value['Key'] ] = $Result->Data;
		}
	}

	function Get_Data_From_Hash($Data){
		$Hashed_Data = [];
		foreach ($Data as $key => $Value) {
			$Result = NULL;

			if ( $Value['Type'] == 'User' )
				$Result = $this->Get_Hashed_Users($Value['Data']);
			else if ( $Value['Type'] == 'Waiting_User' )
				$Result = $this->Get_Hashed_WaitingUsers($Value['Data']);
			else if ( $Value['Type'] == 'Session' )
				$Result = $this->Get_Hashed_Session($Value['Data']);
			else if ( $Value['Type'] == 'SignUP_Token' )
				$Result = $this->Get_Hashed_SignUP_Token($Value['Data']);
			else if ( $Value['Type'] == 'Login_Token' )
				$Result = $this->Get_Hashed_Login_Token($Value['Data']);
			else if ( $Value['Type'] == 'POSTS' )
				$Result = $this->Get_Hashed_POSTS($Value['Data']);
			else if ( $Value['Type'] == 'interested' )
				$Result = $this->Get_Hashed_interested($Value['Data']);
			else if ( $Value['Type'] == 'Comments' )
				$Result = $this->Get_Hashed_Comments($Value['Data']);
			else if ( $Value['Type'] == 'Like_DisLike' )
				$Result = $this->Get_Hashed_Like_DisLike($Value['Data']);
			else if ( $Value['Type'] == 'Notifications' )
				$Result = $this->Get_Hashed_Notifications($Value['Data']);
			else if ( $Value['Type'] == 'Messages' )
				$Result = $this->Get_Hashed_Messages($Value['Data']);
			else{
				$Hashed_Data[ $Value['Key'] ] = $Value['Data'];
				//$GLOBALS[ $Value['Key'] ] = $Value['Data'];
				continue;
			}
			
			if ( $Result->Result == -1 )
				if ( isset($Value['Default']) )
					$Hashed_Data[ $Value['Key'] ] = $Value['Default'];
					//$GLOBALS[ $Value['Key'] ] = $Value['Default'];
				else
					//$this->Call_Function($Function);
					return Returns(-1);
			else
				$Hashed_Data[ $Value['Key'] ] = $Result->Data;
				//$GLOBALS[ $Value['Key'] ] = $Result->Data;
		}
		return Returns(1, $Hashed_Data);
	}

	private function Call_Function($Function){
		if ( $Function != '' )
			call_user_func($Function);
	}
}