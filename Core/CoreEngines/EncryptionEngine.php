<?php

namespace Core;

class EncryptionEngine{
	
	public static function Encrypt_Data($Data, $Key){

		$encryption_key = base64_decode($Key);
	    // Generate an initialization vector
	    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
	    $encrypted = openssl_encrypt($Data, 'aes-256-cbc', $encryption_key, 0, $iv);
	    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
	    return base64_encode($encrypted . '::' . $iv);
	}

	public static function Decrypt_Data($Data, $Key){
		// Remove the base64 encoding from our key
    	$encryption_key = base64_decode($Key);
    	// To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    	list($encrypted_data, $iv) = explode('::', base64_decode($Data), 2);
    	return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
	}
}