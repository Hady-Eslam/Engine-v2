<?php

namespace Core;

class SerializationEngine{
	
	static function Serialize($Data){
		return serialize($Data);
	}

	static function DeSerialize($Data){
		if ( !is_string($Data) )
			return [];
		return unserialize($Data);
	}
}