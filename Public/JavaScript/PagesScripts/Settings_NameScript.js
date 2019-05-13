$(document).ready(function(){

	$('#NameSubmit').click(function(){
		if ( CheckLength('#Name', Name_Len) == true )
			GO('#NameDiv');
	})
})