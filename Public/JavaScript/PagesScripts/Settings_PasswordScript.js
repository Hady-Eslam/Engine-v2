$(document).ready(function(){
	$('#PasswordSubmit').click(function(){
		Result = CheckLength('#OldPassword', Password_Len);
		Result = CheckLength('#Password', Password_Len, Result);
		if ( CheckPassword(Result) == true )
			GO('#PasswordDiv');
	})
})