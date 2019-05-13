$(document).ready(function(){
    $("#Submit").click(function(event){
        if ( CheckData() == true )
            GO('#interestedDiv');
    });

    $('#Showinterested').click(function(){
        location.href = MyPage;
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
    
    Result = CheckDataLenAndNumber(Result, '#MinStorey', Storey_Len, 0, 20, true);
    Result = CheckDataLenAndNumber(Result, '#MaxStorey', Storey_Len, 0, 20, true);
    Result = CheckMinMax('#MinStorey', '#MaxStorey', Result);

    Result = CheckDataLenAndNumber(Result, '#MinMoney', Money_Len,0,10000000000,true);
    Result = CheckDataLenAndNumber(Result, '#MaxMoney', Money_Len,0,10000000000,true);
    Result = CheckMinMax('#MinMoney', '#MaxMoney', Result);

	if ( $('#Months :selected').text() == '0 Month' )
    	if ( $('#Days :selected').text() == '0 Day' ){
    		$('#Months').css('border-color','red');
        	Result = false;
    	}
    if ( User == 0 ){
    	Result = CheckLength('#Email', Email_Len, Result);
    	return CheckEmailPattern(Result);
    }
	return Result;
}