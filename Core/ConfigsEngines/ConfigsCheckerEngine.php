<?php

namespace Configs;
use Exceptions\ConfigsExceptionsEngine;
use \ArrayAccess;

class ConfigsCheckerEngine implements ArrayAccess{

	protected static function CheckConfigsValues($WantedConfigs, $Configs){
		
		foreach ($WantedConfigs as $Value)
			if ( !array_key_exists($Value, $Configs) )
				throw new ConfigsExceptionsEngine("Configs Not Found $Value");
	}

	public function offsetSet($OffSet, $Value){
		throw new ConfigsExceptionsEngine('Can Not Write in Configs Classes');
	}

	public function offsetExists($OffSet){
		return ( isset($this->Configs[$OffSet]) ) ? True : False;
	}

	public function offsetUnset($OffSet){
		unset($this->$Configs[$OffSet]);
	}

	public function offsetGet($OffSet){
		if ( isset($this->Configs[$OffSet]) )
			return $this->Configs[$OffSet];
		throw new ConfigsExceptionsEngine("Key Not Found $OffSet");
	}
}