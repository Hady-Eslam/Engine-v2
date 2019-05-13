<?php

use CoreModels\ModelExcutionEngine;
use SiteEngines\HashingEngine;

class MySessionHandelerEngine implements SessionHandlerInterface{
    
	private $MySql;
    private $Hashing;

    public function open($savePath, $sessionName){
    	$this->MySql = new ModelExcutionEngine();
    	$this->Hashing = new HashingEngine();
        return True;
    }

    public function close(){
        return True;
    }

    public function destroy($Session_id){/*
        $this->MySql->excute('DELETE FROM session WHERE id = ? ',
                    array( $this->Hashing->Hash_Session($Session_id) ));*/
        return True;
    }

    public function gc($MaxLifeTime){
        return True;
    }

    public function read($Session_id){
        $Result = $this->MySql->FetchOneRow('SELECT * FROM session WHERE id = ?',
                    array( $this->Hashing->Hash_Session($Session_id) ));

    	if ( $Result->Result != 1 )
    		return '';
        return $this->Hashing->Get_Hashed_Session( $Result->Data['data'] )->Data;
    }

    public function write($Session_id, $Session_Data){
    	$this->MySql->excute('REPLACE INTO session (id, data, session_date) '
            .'VALUES (?, ?, ?)',
            array(
                $this->Hashing->Hash_Session($Session_id),
                $this->Hashing->Hash_Session($Session_Data),
                date('D d-m-Y H:i:s')
            ));
        return True;
    }
}

class SessionEngine{

    private $Hashing;
    private $MySql;

    function __construct(){
        $this->MySql = new ModelExcutionEngine();
        $this->Hashing = new HashingEngine();
    }

    function NewSessionID(){
        session_regenerate_id(True);
    }

    function DestroySession(){
        if ( ($Result = $this->MySql->excute('DELETE FROM session WHERE id = ?',
                    array(
                        $this->Hashing->Hash_Session(session_id()),
                    )))->Result == -1 )
            return Returns(-1, 'in Deleting User Session', $Result->Error );
        session_unset();
        session_destroy();
        return Returns(0, 'Done');
    }
}

session_set_save_handler(new MySessionHandelerEngine(), True);
register_shutdown_function('session_write_close');
/*
    session_start Must be writen Before Any Output (echo, print, print_r)
*/
    //echo 'Hello';
/*
    Must There Be $_COOKIE['PHPSESSID'] in Cookie So We Get The session_id 
    otherwise it will make new id
*/
session_start();
    //echo session_id();
//new SessionEngine();
