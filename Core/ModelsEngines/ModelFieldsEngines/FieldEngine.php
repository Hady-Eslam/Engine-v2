<?php

namespace ModelFields;
use Exceptions\ModelExceptionsEngine;

class FieldEngine{
	
	protected function Check(){

		if ( $this->Constraints['Null'] &&
			( $this->Constraints['Unique'] || $this->Constraints['Primary_Key']) )
			throw new ModelExceptionsEngine('Null Must Be False With Primary Key Or Unique');

		else if ( isset($this->Constraints['Max_Length'])&&$this->Constraints['Max_Length'] < 0 )
			throw new ModelExceptionsEngine('Max Length Must Be Bigger Than 0');
	}

	public function GetAttributes(){
		return $this->Constraints;
	}
}