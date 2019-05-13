$(document).ready(function(){
    $("#Submit").click(function(event){
        if ( CheckData() == true )
            GO_GET('#Search_Bar');
    });

    $('#ShowMore').click(function(event){
        ShowMorePosts();
    })
})

function CheckData(){
    Result = CheckDataLenAndNumber(true, '#MinArea', Area_Len, 0, 10000, true);
    Result = CheckDataLenAndNumber(Result, '#MaxArea', Area_Len, 0, 10000, true);
    Result = CheckMinMax('#MinArea', '#MaxArea', Result);

    Result = CheckDataLenAndNumber(Result, '#MinRooms', Rooms_Len, 0, 9, true);
    Result = CheckDataLenAndNumber(Result, '#MaxRooms', Rooms_Len, 0, 9, true);
    Result = CheckMinMax('#MinRooms', '#MaxRooms', Result);

    Result = CheckDataLenAndNumber(Result, '#MinPathRooms', Rooms_Len, 0, 9, true);
    Result = CheckDataLenAndNumber(Result, '#MaxPathRooms', Rooms_Len, 0, 9, true);
    Result = CheckMinMax('#MinPathRooms', '#MaxPathRooms', Result);

    Result = CheckDataLenAndNumber(Result, '#MinMoney', Money_Len,0,10000000000,true);
    Result = CheckDataLenAndNumber(Result, '#MaxMoney', Money_Len,0,10000000000,true);
    return CheckMinMax('#MinMoney', '#MaxMoney', Result);
}

function ShowMorePosts(){

    $.ajax({
        type : "POST",
        url : ShowMoreFindPosts,
        data : 'Count=' + Count_Posts,
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
                    SetError_Function('in Getting More Find Posts',
                        'in FindScript.js', 'in ShowMorePosts Function',
                        Data['Error']['Error Type'], Data['Error']['Error Code'],
                        Data['Error']['Error Message'], true);
            }
            catch(e){
                SetError_Function('in Getting More Find Posts',
                    'in FindScript.js', 'in ShowMorePosts Function', 'JSON Error',
                    '1', 'Failed To Covert JSON', false);
            }    
        }
    });
}