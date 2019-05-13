function DeleteMessage(Message_id){

	if ( !confirm('Are You Sure Want To Delete This Message') ){
		return ;
	}

	$.ajax({
        type : "POST",
        url : DeleteMessagePage,
        data : 'MessageID=' + Message_id,
        error: function (jqXHR, exception) {
            console.log(jqXHR);
            TriggerMessage(3500, 'red', '<p>Error Occurred</p>');
        },
        
        success : function(Data){
        	console.log(Data);
            try{
                Data = JSON.parse(Data);
                if ( Data['Result'] == 0 )
                	TriggerMessage(3500, 'red', '<p>Message Not Found</p>');

                else if ( Data['Result'] == 1 ){
                	TriggerMessage(3500, 'green', '<p>Deleted</p>');
                	$('#' + Message_id).remove();
                }
                else
                    TriggerMessage(3500, 'red', '<p>Error Occurred</p>');
            }
            catch(e){
                SetError_Function('in Deleteing Message',
                    'in MessagesScript.js', 'in DeleteMessage Function', 'JSON Error',
                    '1', 'Failed To Covert JSON', true);
            }    
        }
    });
}