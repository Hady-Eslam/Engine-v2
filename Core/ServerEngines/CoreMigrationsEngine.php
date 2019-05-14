<?php

namespace Server;
use Configs\ModelConfigsEngine;
use Exceptions\ModelExceptionsEngine;
use CoreModels\ModelExcutionEngine;

class CoreMigrationsEngine{
	
	function __construct(){
		$GLOBALS['_Configs_']['_ModelConfigs_'] = 
			new ModelConfigsEngine(_DIR_.'/Configs/ModelConfigs.php');
	}

	function CheckDataBaseConnection(){
		$GLOBALS['PDO'] = ModelExcutionEngine::Get_PDO($GLOBALS['_Configs_']['_ModelConfigs_']);
		if ( $GLOBALS['PDO'] === NULL )
			throw new ModelExceptionsEngine('Can Not Make Connection To The DataBase');
	}

	function CreateSessionsModel(){
		try{

			$SQL = $GLOBALS['PDO']->prepare('CREATE TABLE IF NOT EXISTS `Sessions`(
				`Session_Key` VARCHAR(300) NOT NULL PRIMARY KEY,
				`Session_Data` TEXT NOT NULL ,
				`Expire_Date` DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6)
			)ENGINE=InnoDB;');

			$SQL->execute(array());

			echo "\n\n....Done Making Migrations.....\n\n";
		}
		catch(\PDOException $e){
			throw new ModelExceptionsEngine('Error in Making The Query');
		}
	}
}