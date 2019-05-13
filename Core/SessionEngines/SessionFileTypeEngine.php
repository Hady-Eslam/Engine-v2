<?php

namespace SessionEngines;

use SessionEngines\SessionEngine;

use Core\EncryptionEngine;

class SessionFileTypeEngine extends SessionEngine{
	
	public static function GetSession(){

		if ( !self::GET_SESSION_ID() )
				return [];

		else if ( !file_exists(_DIR_."/Storage/Sessions/SESSION_".$GLOBALS['ENGINE_SESS_ID']) )
			return [];

		return self::Check_LifeTime(
			SerializationEngine::DeSerialize(
				self::CHECK_ENCRYPTED(
					file_get_contents(
						_DIR_."/Storage/Sessions/SESSION_".$GLOBALS['ENGINE_SESS_ID'])
			)));
	}

	private static function Check_LifeTime($Session){
		if ( $Session !== [] ){
			if ( new \DateTime(
				date('d-m-Y H:i:s',
					strtotime('+120 seconds',
						strtotime($Session['Expire_Date'])))) < new \DateTime(date('d-m-Y H:i:s')) )
				return [];
			return $Session['Session_Data'];
		}
		return [];
	}
}