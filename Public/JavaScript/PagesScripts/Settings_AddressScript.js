$(document).ready(function(){

	$('#AddressSubmit').click(function(){
		if ( CheckLength('#Address', Address_Len) == true )
			GO('#AddressDiv');
	})
})