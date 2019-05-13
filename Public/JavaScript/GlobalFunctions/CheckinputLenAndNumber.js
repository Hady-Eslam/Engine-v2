function CheckinputLenAndNumber(id, Len){
    Result = CheckLength('#'+id, Len);
    Result1 = isNumber('#'+id);
    if ( Result == true && Result1 == true )
        $('#'+id).css('border-color', '#EDF3E9');
}