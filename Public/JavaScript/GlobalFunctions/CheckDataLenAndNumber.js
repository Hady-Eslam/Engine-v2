function CheckDataLenAndNumber(Result, id, len, Min, Max, ZeroDefault = false){
    Result = isNumber(id, Result);
    Result = CheckLength(id, len, Result, ZeroDefault);
    if ( $(id).val() > Max || $(id).val() < Min )
        return false
    return Result;
}