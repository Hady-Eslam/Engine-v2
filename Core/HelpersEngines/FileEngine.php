<?php

namespace Helper;

class FileEngine{
	
	static function Exists($File_Name){
		return file_exists($File_Name);
	}

	static function CopyFile(){

	}

	static function MoveFile(){

	}

	static function DeleteFile($File_Name){
		return unlink($File_Name);
	}

	static function RenameFile(){

	}

	static function CreateFile($File_Name){
		
	}

	static function FileSize(){

	}
}