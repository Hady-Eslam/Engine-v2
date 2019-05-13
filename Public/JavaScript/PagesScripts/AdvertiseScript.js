$(document).ready(function(){

    $("#Submit").click(function(event){
        if ( CheckData() == true )
            GO('#AdvertiseDiv');
    });

    $('#ShowAdvertise').click(function(){
        location.href = MyPage;
    })
})

function CheckData(){
    Result = CheckLength('#AddName', Advertise_Name_Len);
    Result = Select('#BigType', 'Select', Result);
    Result = Select('#SmallType', 'Select', Result);
    Result = Select('#Rooms', 'Select', Result);
    Result = Select('#PathRooms', 'Select', Result);
    Result = CheckDataLenAndNumber(Result, '#Area', Area_Len, 0, 10000);
    Result = CheckDataLenAndNumber(Result, '#Money', Money_Len, 0, 10000000000);
    Result = CheckLength('#Discreption', Discreption_Len, Result);
    Result = CheckLength('#City', Address_Len, Result);
    Result = CheckLength('#UserName', Name_Len, Result);
    Result = CheckLength('#Phone', Phone_Len, Result);
    if ( !$('#TermsOfUse').prop('checked') ){
        alert('You Must Agree in Terms Of Use');
        return false;
    }
    return Result;
}


function Select(id, Value, Result){
    if ( $(id+' :selected').text() == Value ){
        $(id).css('border-color', 'red');
        return false;
    }
    return Result;
}