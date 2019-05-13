<?php

namespace CoreModels;
use \PDO;

class ModelExcutionEngine{

	public static function Get_PDO($DataBase){

		$Found_Error = False;
		try{
			$pdo = new PDO($DataBase['DB_LANGUAGE']
								.":host=".$DataBase['DB_HOST']
								.";dbname=".$DataBase['DB_NAME'],
								$DataBase['DB_USER'],
								$DataBase['DB_PASSWORD'],
								array(PDO::MYSQL_ATTR_FOUND_ROWS => True) );
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(\PDOException $e){
			$Found_Error = True;
	    }

		return ( $Found_Error ) ? NULL : $pdo ;
	}
}