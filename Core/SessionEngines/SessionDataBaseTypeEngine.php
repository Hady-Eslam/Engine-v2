<?php

namespace SessionEngines;

use SessionEngines\SessionEngine;

use Core\SerializationEngine;

use Exceptions\SessionExceptionsEngine;

class SessionDataBaseTypeEngine extends SessionEngine{
	
	static function GetSession(){

		if ( $GLOBALS['PDO'] === NULL )
			throw new SessionExceptionsEngine(
				'Error in DataBase Connection To Get Session Data');

		else if ( !self::CheckLottary('DATABASE') )
			throw new SessionExceptionsEngine('Error in Deleting Old Sessions');

		$FOUND = False;

		try{
			if ( !self::GET_SESSION_ID() )
				return [];

			$SQL = $GLOBALS['PDO']
				->prepare(
					'SELECT * FROM `Sessions` WHERE `Session_Key` = ? AND `Expire_Date` > NOW()');

			$SQL->execute(
					array(
						$GLOBALS['ENGINE_SESS_ID']
					)
				);

			$Session = self::CHECK_ENCRYPTED( $SQL->fetch(\PDO::FETCH_ASSOC) );
			if ( $Session !== [] )
				return SerializationEngine::DeSerialize(
					$Session['Session_Data']	
				);
			
			return $Session;

		}
		catch(\PDOException $e){
			$FOUND = True;
		}
		finally{
			if ( $FOUND )
				throw new SessionExceptionsEngine('Error in PDO excute');
		}
	}

	static function SaveSession($Render, $CSRF_TOKEN){

		$Request = self::Check_Render($Render);
		
		if ( $Request === False )
			return ;
		
		if ( !is_object($Request) || get_class($Request) !== 'Core\Request' )
			throw new SessionExceptionsEngine('Render Returned WithOut Request Type');

		//var_dump($Request->SESSION['CSRF']);
		if ( $CSRF_TOKEN !== NULL ){

			if ( !isset($Request->SESSION['CSRF']) ){
				$Request->SESSION['CSRF'] = [
					$CSRF_TOKEN => True
				];
			}
			else{
				$CSRF = $Request->SESSION['CSRF'];
				$CSRF[$CSRF_TOKEN] = True;
				if ( sizeof($CSRF) > 30 )
					array_shift($CSRF);
				$Request->SESSION['CSRF'] = $CSRF;
			}
		}

		if ( $Request->SESSION->isEmpty() )
			setcookie('ENGINE_SESS_ID', '', time()-3600, '/');
		else{
			$SQL = $GLOBALS['PDO']->prepare(
				'UPDATE `Sessions` SET `Session_Data` = ? WHERE `Session_Key` = ?'
			);

			$SQL->execute(array(
				self::TO_ENCRYPT(
					SerializationEngine::Serialize( $Request->SESSION->GetSession() )
				),
				$Request->SESSION->GetSessionID()
			));

			if ( $SQL->rowCount() == 0 ){

				$SQL = $GLOBALS['PDO']->prepare(
					'INSERT INTO `Sessions`(`Session_Key`, `Session_Data`, `Expire_Date`) VALUES (?, ?, ?)'
				);

				$SQL->execute(array(
					$Request->SESSION->GetSessionID(),
					self::TO_ENCRYPT(
						SerializationEngine::Serialize( $Request->SESSION->GetSession() )
					),
					date('Y-m-d H:i:s',
						strtotime('+'.$GLOBALS['_Configs_']['_SessionConfigs_']['LIFE_TIME']
								.' seconds',
							strtotime(date('Y-m-d H:i:s')))).'.000000'
				));
			}
		}
	}

	static function SaveRedirectSession($Request){

		if ( $Request->SESSION->isEmpty() )
			setcookie('ENGINE_SESS_ID', '', time()-3600, '/');
		else{
			$SQL = $GLOBALS['PDO']->prepare(
				'UPDATE `Sessions` SET `Session_Data` = ? WHERE `Session_Key` = ?'
			);

			$SQL->execute(array(
				self::TO_ENCRYPT(
					SerializationEngine::Serialize( $Request->SESSION->GetSession() )
				),
				$Request->SESSION->GetSessionID()
			));

			if ( $SQL->rowCount() == 0 ){

				$SQL = $GLOBALS['PDO']->prepare(
					'INSERT INTO `Sessions`(`Session_Key`, `Session_Data`, `Expire_Date`) VALUES (?, ?, ?)'
				);

				$SQL->execute(array(
					$Request->SESSION->GetSessionID(),
					self::TO_ENCRYPT(
						SerializationEngine::Serialize( $Request->SESSION->GetSession() )
					),
					date('Y-m-d H:i:s',
						strtotime('+'.$GLOBALS['_Configs_']['_SessionConfigs_']['LIFE_TIME']
								.' seconds',
							strtotime(date('Y-m-d H:i:s')))).'.000000'
				));
			}
		}
	}
}