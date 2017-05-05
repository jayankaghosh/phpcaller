<?php

class Helper {
	

	const COMMANDS = array(
		"search"	=>	"Search for an account by it's number. Usage: ./truecaller search <number>",
		"list"		=>	"Lists all available commands",
		"help"		=>	"Shows the help manual"
	);

	const BEARER_FILENAME = '.bearer';
	const README_FILENAME = 'README.md';


	private $_newLineCharacter, $_tabCharacter;

	public function __construct($nl = "\n", $t = "\t"){
		$this->_newLineCharacter = $nl;
		$this->_tabCharacter = $t;
	}

	public function showHeader(){
	echo $this->_tabCharacter.Output::colorString("PHPCALLER - A PHP wrapper for the Truecaller API", "success").$this->_newLineCharacter.$this->_tabCharacter.Output::colorString("MADE WITH L").Output::colorString("<3", "error").Output::colorString("VE BY ").Output::colorString("j0y <jayankaghosh@gmail.com>", "success");
	echo $this->_newLineCharacter.$this->_newLineCharacter.$this->_tabCharacter.Output::colorString("DISCLAIMER: ", "success").Output::colorString(" This was purely a hobby project with no intention of distributing or marketing this software");	
	}

	public function listCommands(){
		foreach(self::COMMANDS as $command => $description){
			echo $this->_tabCharacter.$command.$this->_tabCharacter;
			echo Output::colorString($description, "success");
			echo $this->_newLineCharacter;
		}
		echo $this->_newLineCharacter;
	}

	public function displayManPage(){
		if(!file_exists(self::README_FILENAME)){
			echo "File README.md not found!";
			return;
		}
		$manPage = explode("\n", file_get_contents(self::README_FILENAME));
		foreach ($manPage as $line) {
			echo Output::colorString(chunk_split($line, 130));
		}

	}

	public function setBearer($bearerId){
		try{
			$file = fopen(self::BEARER_FILENAME, "w+");
			fwrite($file, $bearerId);
			fclose($file);
			Output::write(Output::colorString("Bearer ID set successfully", "success"));
		}
		catch(Exception $e){
			Output::write(Output::colorString("Error setting bearer ID!", "error")." Reason: ".Output::colorString($e->getMessage(),"info"));
		}
	}


	public function getBearer(){
		$this->validateBearer();
		return file_get_contents(self::BEARER_FILENAME);
	}


	public function validateBearer(){
		if(!file_exists(self::BEARER_FILENAME)){
			Output::write(Output::colorString("ERROR: ", "error").Output::colorString("Bearer file not found! Please include bearer for authorization. Type \"php truecaller help\" for information on how to include bearer"));
			exit(0);
		}
	}
}