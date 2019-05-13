/*
    - info :
        javascript page     =>  CheckName.js
        init name           =>  CheckNameScript

    -The Scripts it Depends On (init Name) :
        JQueryScript
        SetMessageBoxScript

    - Data Needed :
        id  => #Name
        var => Name_Len
        var => CheckPage
*/

function CheckPhone(){

    if ( $('#Phone').val().length == 0 )
        return ;

    else if ( $('#Phone').val().length > Phone_Len ){
        $('#Phone').css('border-color', 'red');
        return ;
    }

    $.ajax({
        type : "POST",
        url : CheckPage,
        data : 'Phone='+$('#Phone').val(),
        error: function (jqXHR, exception) {
            console.log(jqXHR);
        },
        
        success : function(Data){
            console.log(Data);
            try{
                Data = JSON.parse(Data);
                if ( Data['Result'] == 0 )
                    if ( Data['Data'] == 'phone Not Found' )
                        $('#Phone').css('border-color','green');
                    else
                        $('#Phone').css('border-color','red');
                else
                    SetError_Function('in Searching For Phone Reservied Or Not',
                        'in CheckPhoneScript.js', 'in CheckPhone Function',
                        Data['Error']['Error Type'], Data['Error']['Error Code'],
                        Data['Error']['Error Message'], true);
            }
            catch(e){
                SetError_Function('in Searching For Phone Reservied Or Not',
                    'in CheckPhoneScript.js', 'in CheckPhone Function', 'JSON Error',
                    '1', 'Failed To Covert JSON', false);
            }    
        }
    });
}