<?php

function ShowResults(){
	if ( $GLOBALS['Result'] == 'Post Not Found' )
        return '<p style="color:red;margin-top:100px;">This Post Not Found Or Deleted</p>';

    else if ( $GLOBALS['Result'] == 'User Not Found' )
        return '<p style="color:red;margin-top:100px;">This User Not Found Or Deleted</p>';

    else if ( $GLOBALS['Result'] == 'Posts Deleted' )
        return '<p style="color:green;margin-top:100px;">Post Deleted</p>';
    
    else if ( $GLOBALS['Result'] == 'Posts Accepted' )
        return '<p style="color:green;margin-top:100px;">Post Has Been Approved</p>';

    else if ( $GLOBALS['Result'] == 'Posts Rejected' )
        return '<p style="color:green;margin-top:100px;">Post Has Been Rejected</p>';

    else if ( $GLOBALS['Result'] == 'Account Deleted' )
        return '<p style="color:green;margin-top:100px;">Account Has Been Deleted</p>';
}