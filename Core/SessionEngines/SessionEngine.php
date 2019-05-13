<?php

namespace SessionEngines;

use Core\EncryptionEngine;

class SessionEngine{
	
	protected static function GET_SESSION_ID(){

		if ( isset($_COOKIE['ENGINE_SESS_ID']) ){
			$GLOBALS['ENGINE_SESS_ID'] = $_COOKIE['ENGINE_SESS_ID'];
			return True;
		}

	    $GLOBALS['ENGINE_SESS_ID'] =
	    	password_hash( time() . bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

	    setcookie('ENGINE_SESS_ID', $GLOBALS['ENGINE_SESS_ID'],
	    	time() + $GLOBALS['_Configs_']['_SessionConfigs_']['LIFE_TIME'], '/');
	    return False;
	}

	protected static function CHECK_ENCRYPTED($Session){
		if ( $Session === [] )
			return [];

		else if ( !$GLOBALS['_Configs_']['_SessionConfigs_']['ENCRYPT'] )
			return $Session;

		return EncryptionEngine::Decrypt_Data($Session,
			$GLOBALS['_Configs_']['_AppConfigs_']['ENCREPTION_KEY'].'Session');
	}

	protected static function Check_Render($Render){
		
		if ( $Render[0] != 'Done' )
			return False;

		else if ( sizeof($Render[1]) == 2 )
			return $Render[1][0];

		else if ( sizeof($Render[1]) == 3 )
			return $Render[1][0];

		else
			return False;
	}

	protected static function TO_ENCRYPT($Data){
		if ( !$GLOBALS['_Configs_']['_SessionConfigs_']['ENCRYPT'] )
			return $Data;

		return EncryptionEngine::Encrypt_Data($Data,
			$GLOBALS['_Configs_']['_AppConfigs_']['ENCREPTION_KEY'].'Session');
	}

	static function CheckLottary($Session_Type){
		$Count = file_get_contents(_DIR_.'/Storage/Sessions/SESSION_CONFIGS');
		$Count = ( $Count !== '' ) ? substr($Count, 1) : '0';
		if ( $Count >= $GLOBALS['_Configs_']['_SessionConfigs_']['PROBABILITY'] ){
			return ( $Session_Type === 'DATABASE' ) ?
					self::DeleteDataBassSessions() :
					self::DeleteFileSessions();
		}
		else{
			$Count++;
			file_put_contents(_DIR_.'/Storage/Sessions/SESSION_CONFIGS', '_'.$Count, LOCK_EX);
			return True;
		}
	}

	private static function DeleteDataBassSessions(){
		try{
			$SQL = $GLOBALS['PDO']->prepare('DELETE FROM `Sessions` WHERE `Expire_Date` < NOW()');
			$SQL->execute(array());
			file_put_contents(_DIR_.'/Storage/Sessions/SESSION_CONFIGS', '_0', LOCK_EX);
			return True;
		}
		catch(\PDOException $e){
			return False;
		}
	}
}