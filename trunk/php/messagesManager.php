<?php

class MessagesManager
{
	protected $fileName;
	
	public function __construct($fileName)
	{
		$this->fileName = $fileName;
	}

	public function addMessage($owner, $receiver, $message)
	{
		// Définit le fuseau horaire par défaut à utiliser.
		date_default_timezone_set('UTC');
		
		$msg = array('owner' => $owner, 'message' => $message, 'date' => date("Y-m-d H:i:s"));
		
		if( ! file_exists($this->fileName) )
		{
			// Create or read file $fileName
			$file = fopen($this->fileName, 'c');
			$data['messages'] = array();
			
			fwrite($file, json_encode($data));
			fclose($file);
		}
		
		$json = json_decode(file_get_contents($this->fileName), true);
		
		if( ! array_key_exists($receiver, $json['messages']) )
		{
			$json['messages'][$receiver] = array($msg);
		}
		else
		{
			array_push($json['messages'][$receiver], $msg);			
		}
		
		file_put_contents($this->fileName, json_encode($json));
	}

	public function removeMessages($nickname)
	{
		if( file_exists($this->fileName) )
		{
			$json = json_decode(file_get_contents($this->fileName), true);

			unset($json['messages'][$nickname]);
			
			file_put_contents($this->fileName, json_encode($json));
		}
	}
	
	public function getMessages($nickname)
	{
		$messages = array();
		
		if( file_exists($this->fileName) )
		{
			$json = json_decode(file_get_contents($this->fileName));
			
			if( array_key_exists($nickname, $json->messages) )
			{
				foreach( $json->messages->$nickname as $msg )
				{
					array_push($messages, $msg);
				}
			}
		}
		
		return $messages;
	}
}

function getMessagesFilePath()
{
	// Analyse sans sections
	$config_array = parse_ini_file("configuration.ini");

	return $config_array["messagesFilePath"];
}

?>
