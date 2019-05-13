<?php

namespace Configs;
use Configs\ConfigsCheckerEngine;

class AppConfigsEngine extends ConfigsCheckerEngine{
	
	function __construct($ConfigsPath){

		$this->Configs = include_once $ConfigsPath;
		self::CheckConfigsValues([
			'ENGINE_NAME' ,
			'CURRENT_ENV',
			'DEBUG',
			'URL',
			'TIMEZONE',
			'MAIN_LANGUAGE',
			'BACKUP_LANGUAGES',
			'ENCREPTION_KEY',
			'CORE_PATH',
			'SCHEMA',
			'VIEWS' ,
			'TEMPLATES',
			'TEMPLATES_FILTERS',
			'MIDDLE_WARE'
		], $this->Configs);
	}
}
