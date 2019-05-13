$(document).ready(function(){

	$('#SendMessage').click(function(event){
		if ( CheckData() == true )
            GO('#MakeMessage');
	})
})

function CheckData(){
    
    if ( $('#MessageEmail').length != 0 ){
        if ( !CheckLength('#MessageEmail', Email_Len) ){
            $('#MessageEmail').css('border-color', 'red');
            return false;
        }
        Email = '&MessageEmail=' + $('#MessageEmail').val();
    }
    else
        Email = '';

    if ( !CheckLength('#Message', Message_Len) ){
        $('#Message').css('border-color', 'red');
        return false;
    }

    return true;
}