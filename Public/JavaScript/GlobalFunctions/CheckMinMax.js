function CheckMinMax(Min_id, Max_id, Result){
	if ( $(Min_id).val().length != 0 && $(Max_id).val().length != 0 )
		if ( $(Min_id).val() > $(Max_id).val() ){
	        $(Min_id).css('border-color', 'red');
	        $(Max_id).css('border-color', 'red');
	        return false;
	    }
	return Result;
}