<?php

namespace Server;
use Configs\ModelConfigsEngine;
use Exceptions\ModelExceptionsEngine;
use CoreModels\ModelExcutionEngine;

class CoreMigrationsEngine{
	
	function __construct(){
		echo "Searching For Models ... \n";
		$this->FoundModels = [];
		$this->Models = [];
		$this->RegisteredModels = [];
		$this->BuildQuery = '';
		$this->LoadConfigs();
		$this->SearchForModels();
		$this->ScanRegisteredModels();
	}

	private function LoadConfigs(){
		$GLOBALS['_Configs_']['_ModelConfigs_'] = 
			new ModelConfigsEngine(_DIR_.'/Configs/ModelConfigs.php');
	}

	private function SearchForModels(){

		$DIR = _DIR_.'/Models/';
		$Directories = [];
		
		while (true) {
			
			$Paths = array_slice(scandir($DIR), 2);
			foreach ($Paths as $key => $Value) {

				if ( is_dir($DIR.$Value) )
					$Directories[] = $DIR.$Value."/";
				else{
					$Path = array_slice(explode('.', $Value), -1);
					if ( sizeof($Path) != 0 && $Path[0] == 'php' )
						require_once $DIR.$Value;
				}
			}
			if ( empty($Directories) )
				break;
			$DIR = array_slice($Directories, 0, 1)[0];
			$Directories = array_slice($Directories, 1);
		}

		foreach (get_declared_classes() as $Value)
			if ( preg_match('/^Models\\.*/', $Value) ){
				$this->FoundModels[] = $Value;
				echo "\n\tFound Model :: $Value";
			}
	}

	private function ScanRegisteredModels(){

		if ( file_exists( _DIR_.'/Storage/Models/RegisteredModels' ) )
			$this->RegisteredModels = json_decode(
		 			file_get_contents(_DIR_.'/Storage/Models/RegisteredModels'), True );
		else{
			$this->RegisteredModels = [];
			$File_Handle = fopen(_DIR_.'/Storage/Models/RegisteredModels', 'w') or die(
					'Unable to open Models file!');
			fclose($File_Handle);
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	function ScanningModels(){
		
		echo "\n\nScanning Models .......... ";

		foreach ($this->FoundModels as $Model_Name){

			echo "\n\n\tScan Model :: $Model_Name\n";

			$Short_Model_Name = array_slice( explode('\\', $Model_Name), -1)[0];

			$Model = new $Model_Name();

			if ( !in_array('CoreModels\ModelEngine', class_parents($Model)) )
				throw new ModelExceptionsEngine(
					"Model ( $Model_Name ) Must Extends From ModelEngine Class Parent");

			$Fields = get_object_vars($Model);
			if ( sizeof($Fields) < 1 )
				throw new ModelExceptionsEngine('Your Model Must Have Fields');

			if ( !isset($this->RegisteredModels[$Short_Model_Name]) )
				$this->CheckNewModelFields($Fields, $Short_Model_Name);
			else
				$this->CheckOldModelFields($Fields, $Short_Model_Name);

			usleep(100 * MilliSecond);
		}
	}

	private $SupportedFieldsTypes = [
		'ModelFields\RelationsTypes\BitPrimaryKeyFieldEngine',
		'ModelFields\RelationsTypes\DecimalPrimaryKeyFieldEngine',
		'ModelFields\RelationsTypes\IntegerPrimaryKeyFieldEngine',
		'ModelFields\RelationsTypes\StringPrimaryKeyFieldEngine',
		'ModelFields\RelationsTypes\TimeStampPrimaryKeyFieldEngine',

		'ModelFields\IntegerTypes\BitFieldEngine',
		'ModelFields\IntegerTypes\BooleanFieldEngine',
		'ModelFields\IntegerTypes\SmallIntegerFieldEngine',
		'ModelFields\IntegerTypes\MediumIntegerFieldEngine',
		'ModelFields\IntegerTypes\IntegerFieldEngine',
		'ModelFields\IntegerTypes\BigIntegerFieldEngine',

		'ModelFields\DecimalTypes\FloatFieldEngine',
		'ModelFields\DecimalTypes\DoubleFieldEngine',
		'ModelFields\DecimalTypes\DecimalFieldEngine',

		'ModelFields\DateTypes\DateFieldEngine',
		'ModelFields\DateTypes\TimeFieldEngine',
		'ModelFields\DateTypes\YearFieldEngine',
		'ModelFields\DateTypes\DateTimeFieldEngine',

		'ModelFields\StringTypes\CharFieldEngine',
		'ModelFields\StringTypes\VarCharFieldEngine',
		'ModelFields\StringTypes\TextFieldEngine',
		'ModelFields\StringTypes\MediumTextFieldEngine',
		'ModelFields\StringTypes\LongTextFieldEngine',

		'ModelFields\SelectTypes\SetFieldEngine',
		'ModelFields\SelectTypes\EnumFieldEngine',
	];

	private function CheckNewModelFields($Fields, $Model_Name){
		$Query = "CREATE TABLE IF NOT EXISTS `$Model_Name` (";
		$Primary_Key = ' PRIMARY KEY ( ';
		$this->RegisteredModels[$Model_Name] = [];
		$this->Models[$Model_Name] = [];


		foreach ($Fields as $Field_Name => $Field_Object ) {

			if ( gettype($Field_Object) != 'object' )
				throw new ModelExceptionsEngine("The Field ( $Field_Name ) Must Be Object");

			$ClassType = get_class($Field_Object);
			if ( !in_array($ClassType, $this->SupportedFieldsTypes) )
				throw new ModelExceptionsEngine("There no Such Field Type ( $ClassType )");

			$Field_Query = $Field_Object->BuildNewFieldQuery($Field_Name);
			$Query .= $Field_Query;
			$this->Models[$Model_Name][$Field_Name] = $Field_Object->GetAttributes();

			if ( isset($Field_Object->Constraints['Primary_Key']) &&
				$Field_Object->Constraints['Primary_Key'] == True )
				$Primary_Key .= "`$Field_Name` ,";

			echo "\t\tDone Checking Field :: $Field_Name\n";
		}

		if ( $Primary_Key !== ' PRIMARY KEY ( ' )
			$this->BuildQuery .= $Query.substr($Primary_Key, 0, strlen($Primary_Key)-2 )
									.' ) )ENGINE=InnoDB;';
		else
			$this->BuildQuery .= substr($Query, 0, strlen($Query)-1 ).')ENGINE=InnoDB;';
	}

	private function CheckOldModelFields($Fields, $Model_Name){

		$AlterModelQuery = 
			"DROP INDEX IF EXISTS `PRIMARY` ON `$Model_Name`;ALTER TABLE `$Model_Name` ";

		$Primary_Key = '';

		foreach ($Fields as $Field_Name => $Field_Object ) {

			if ( gettype($Field_Object) != 'object' )
				throw new ModelExceptionsEngine("The Field ( $Field_Name ) Must Be Object");

			$ClassType = get_class($Field_Object);
			if ( !in_array($ClassType, $this->SupportedFieldsTypes) )
				throw new ModelExceptionsEngine("There no Such Field Type ( $ClassType )");

			if ( !isset($this->RegisteredModels[$Model_Name][$Field_Name]) ){
				$AlterModelQuery .= ' ADD '.$Field_Object->BuildNewFieldQuery($Field_Name);
				$this->Models[$Model_Name][$Field_Name] =  $Field_Object->GetAttributes();
			}
			else{
				if ( $this->RegisteredModels[$Model_Name][$Field_Name] !==
						$Field_Object->GetAttributes() ){

					$this->isValidConvert(
						$Field_Object->GetAttributes(),
						$this->RegisteredModels[$Model_Name][$Field_Name]);

					$AlterModelQuery .= ' MODIFY COLUMN '
									.$Field_Object->BuildNewFieldQuery($Field_Name);

					$this->Models[$Model_Name][$Field_Name] =  $Field_Object->GetAttributes();
				}
				else
					$this->Models[$Model_Name][$Field_Name] =  $Field_Object->GetAttributes();
			}

			if ( isset($Field_Object->Constraints['Primary_Key']) &&
				$Field_Object->Constraints['Primary_Key'] == True )
				$Primary_Key .= "`$Field_Name` ,";

			echo "\t\tDone Checking Field :: $Field_Name\n";
		}

		if ( $AlterModelQuery !== 
				"DROP INDEX IF EXISTS `PRIMARY` ON `$Model_Name`;ALTER TABLE `$Model_Name` " ){

			$this->BuildQuery .= substr($AlterModelQuery, 0, strlen($AlterModelQuery) - 1);

			if ( $Primary_Key !== '' )
				$this->BuildQuery .= ', ADD PRIMARY KEY ( '.
					substr($Primary_Key, 0, strlen($Primary_Key)-1).' )';
			$this->BuildQuery .= ';';
		}
	}

	private function isValidConvert($Field_Constraints, $Registered_Constraints){
		
		if ( $Field_Constraints['Field_Type'] === $Registered_Constraints['Field_Type'] )
			return ;

		echo "\n\n\t\t".'Warning : You May Lose Some Data if You Convert The Field From ( '.
			$Registered_Constraints['Field_Type'].' ) To ( '.$Field_Constraints['Field_Type']
			.' )'."\n\n";

	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	function SaveModels(){
		if ( $this->BuildQuery !== '' ){
			$Data = json_encode($this->Models);
			unlink(_DIR_.'/Storage/Models/RegisteredModels');
			$File_Handle = fopen(_DIR_.'/Storage/Models/RegisteredModels', 'w') or die(
					'Unable to open Models file!');
			fclose($File_Handle);
			file_put_contents(_DIR_.'/Storage/Models/RegisteredModels', $Data, LOCK_EX);
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	function DeleteUneccessary(){
		foreach ($this->RegisteredModels as $Model_Name => $Model_Fields) {
			if ( !isset($this->Models[$Model_Name]) )
				$this->BuildQuery .= "DROP TABLE IF EXISTS `$Model_Name`;";
			else
				foreach ($Model_Fields as $Field_Name => $Field_Constraints)
					if ( !isset($this->Models[$Model_Name][$Field_Name]) )
						$this->BuildQuery .= "ALTER TABLE `$Model_Name` DROP `$Field_Name`;";
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	function PutFrameWorkModels(){
		$this->BuildQuery .= 'CREATE TABLE IF NOT EXISTS `Sessions`(
								`Session_Key` VARCHAR(300) NOT NULL PRIMARY KEY,
								`Session_Data` TEXT NOT NULL ,
								`Expire_Date` DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6)
							)ENGINE=InnoDB;';
	}


	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	function MakeMigrations(){
		$ExcutionEngine = ModelExcutionEngine::Get_PDO($GLOBALS['_Configs_']['_ModelConfigs_']);
		if ( $ExcutionEngine === NULL )
			throw new ModelExceptionsEngine('Can Not Make Connection To The DataBase');

		try{
			$SQL = $ExcutionEngine->prepare( $this->BuildQuery );
			$SQL->execute(array());
			echo "\nDone Migrations...\n";
		}
		catch(\PDOException $e){
			echo 'Error in Making Migrations : '.$e->getMessage();
		}
	}
}