/*
    - info :
        javascript page     =>  CheckNumberOrNot.js
        init name           =>  CheckNumberOrNotScript

    -The Scripts it Depends On (init Name) :
        JQueryScript
*/

function isNumber(id, Result = true){
	if ( isNaN( $(id).val() ) == false )
		return Result;
	$(id).css('border-color', 'red');
	return false;
}