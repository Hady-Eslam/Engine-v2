<?php

namespace Core;

class TimerEngine{
	
	function __construct(){
		//$this->REQUEST_TIME_FLOAT = $Request->SERVER('REQUEST_TIME_FLOAT');
		$this->TurnEngineOn();//$REQUEST_TIME_FLOAT);
	}

	private function TurnEngineOn(){
		//$this->StartWebSiteRequest = $RequestTime;
		$this->StartWebSiteEngine = START_ENGINE;
		$this->StartEngine = microtime(true);
	}

	function Start(){
		return $this->StartEngine = microtime(true);
	}

	function End(){
		return ($this->Ended = microtime(true) - $this->StartEngine);
	}

	function ShowTime(){
		echo '<br>MilliSeconds = '.($this->Ended*1000).'<br>';
	}

	function EndSiteTimer(){
		return ($this->Ended = microtime(true) - $this->StartWebSiteEngine);
	}
}