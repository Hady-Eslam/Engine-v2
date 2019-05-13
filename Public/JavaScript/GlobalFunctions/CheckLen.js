/*
	- info :
		javascript page    	=>  CheckLength.js
        init name   		=>  CheckLengthScript

	-The Scripts it Depends On (init Name) :
		JQueryScript
*/
function CheckLength(id, len, Result = true, ZeroDefault = false){
    if ( $(id).val().length > len || ZeroDefault == false && $(id).val().length == 0 ){
    		$(id).css('border-color','red');
    		return false;
    }
    return Result;
}