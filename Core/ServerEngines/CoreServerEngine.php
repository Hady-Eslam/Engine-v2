<?php

namespace Server;

use ErrorsHandlers\ErrorsHandlerEngine;
use Server\CoreMigrationsEngine;
use Core\DefinesEngine;

class CoreServerEngine{
	
	function __construct(){
		echo "\n\n.... Welcome To Server Engine ....\n\n";
		new ErrorsHandlerEngine();
		new DefinesEngine('ServerEngine');
	}

	function CheckCommand($argv){
		if ( !isset($argv) ){
			echo "Server Must Work From Command Line\n\n";
			exit();
		}
		else if ( sizeof($argv) < 2 ){
			echo "Type 'ServerEngine <subcommand>' To Server.\n\n";
			exit();
		}
		else if ( strtoupper($argv[1]) !== 'MAKEMIGRATIONS' ){
			echo "UnDefiened Command\n\n";
			exit();
		}

		$this->Command = 'MakeMigrations';
	}
	
	function ExcuteCommand(){
		if ( $this->Command == 'MakeMigrations' )
			$this->MigrationsServer();
	}
	
	private function MigrationsServer(){
		$CoreMigrationsServer = new CoreMigrationsEngine();
		$CoreMigrationsServer->CheckDataBaseConnection();
		$CoreMigrationsServer->CreateSessionsModel();
	}
}