/*
	- info :
		javascript page    	=>  CheckinputLen.js
        init name   		=>  CheckinputLenScript

	-The Scripts it Depends On (init Name) :
		JQueryScript
		CheckLenScript
*/

// Functions For input 
function CheckinputLen(id, Len){
    if ( CheckLength('#'+id, Len) == true ){
        $('#'+id).css('border-color', '#edf3e9');
        return true;
    }
    return false;
}