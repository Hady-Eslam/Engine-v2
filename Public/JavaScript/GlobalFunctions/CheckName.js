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

function CheckName(){

    if ( $('#Name').val().length == 0 || $('#Name').val().length > Name_Len )
        return ;

    $.ajax({
        type : "POST",
        url : CheckPage,
        data : 'Name='+$('#Name').val(),
        error: function (jqXHR, exception) {
            console.log(jqXHR);
        },
        
        success : function(Data){
            try{
                Data = JSON.parse(Data);
                if ( Data['Result'] == 0 )
                    if ( Data['Data'] == 'name Not Found' )
                        $('#Name').css('border-color','green');
                    else
                        $('#Name').css('border-color','red');
                else
                    SetError_Function('in Searching For Name Reservied Or Not',
                        'in CheckNameScript.js', 'in CheckName Function',
                        Data['Error']['Error Type'], Data['Error']['Error Code'],
                        Data['Error']['Error Message'], true);
            }
            catch(e){
                SetError_Function('in Searching For Name Reservied Or Not',
                    'in CheckNameScript.js', 'in CheckName Function', 'JSON Error',
                    '1', 'Failed To Covert JSON', false);
            }    
        }
    });
}