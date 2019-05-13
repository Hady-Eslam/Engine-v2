<?php 

namespace SiteEngines;

class JsonEngine{

	function MakeJson($Object){
		try{
			return json_encode($Object);
		}
		catch (Exception $e){
			return json_encode( Returns(-1, '',
				Error('JSON Error', '15', 'Error in Converting To JSON') ) );
		}
	}
}