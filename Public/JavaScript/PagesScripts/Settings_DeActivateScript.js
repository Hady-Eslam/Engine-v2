$(document).ready(function(){

	$('#DeactivateSubmit').click(function(){
		if ( confirm('Are You Sure Want To De-Activate Acount ?') == true )
			GO('#DeactivateDiv');
	})

	$('#DeleteSubmit').click(function(){
		if ( confirm('Are You Sure Want To Delete Acount ?') == true )
			GO('#DeactivateDiv');
	})
})