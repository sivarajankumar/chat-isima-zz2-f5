<?php

function getMessagesFilePath()
{
	// Analyse sans sections
	$config_array = parse_ini_file("configuration.ini");

	return $config_array["messagesFilePath"];
}

function addMessage($owner, $receiver, $message)
{
	// Définit le fuseau horaire par défaut à utiliser.
	date_default_timezone_set('UTC');
	$fileName = getMessagesFilePath();
	
	$msg = array('owner' => $owner, 'message' => $message, 'date' => date("Y-m-d H:i:s"));
	
	if( ! file_exists($fileName) )
	{
		// Create or read file $fileName
		$file = fopen($fileName, 'c');
	
		$messages[] = $msg;
		$data[$receiver] = $messages;
	
		fwrite($file, json_encode($data));
		fclose($file);
	}
	else
	{
		$json = json_decode(file_get_contents($fileName), true);
	
		array_push($json[$receiver], $msg);
	
		file_put_contents($fileName, json_encode($json));
	}
}

?>