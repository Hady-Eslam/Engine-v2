$(document).ready(function(){

	$('#PhoneSubmit').click(function(){
		if ( CheckLength('#Phone', Phone_Len) == true )
			GO('#PhoneDiv');
	})
})