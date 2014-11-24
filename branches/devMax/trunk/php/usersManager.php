<?php

function getUsersFilePath()
{
	// Analyse sans sections
	$config_array = parse_ini_file("configuration.ini");
	
	return $config_array["usersFilePath"];
}

function addUsers($nickname, $rememberMe)
{
	// Définit le fuseau horaire par défaut à utiliser.
	date_default_timezone_set('UTC');
	$fileName = getUsersFilePath();
	
	
	if( ! file_exists($fileName) )
	{
		// Create or read file $fileName
		$file = fopen($fileName, 'c');
		
		$username[] = array('nickname' => $nickname, 'rememberMe' => $rememberMe, 'date' => date("Y-m-d H:i:s"));
		$data['users'] = $username;
		
		fwrite($file, json_encode($data));
		fclose($file);
	}
	else
	{
		$json = json_decode(file_get_contents($fileName), true);
		
		array_push($json['users'], array('nickname' => $nickname, 'rememberMe' => $rememberMe, 'date' => date("Y-m-d H:i:s")));
		
		file_put_contents($fileName, json_encode($json));
	}
}

function removeUsers($nickname)
{
	$fileName = getUsersFilePath();
	
	if( file_exists($fileName) )
	{
		$json = json_decode(file_get_contents($fileName));
		
		$i = 0;
		foreach( $json->users as $item )
		{
			if( $item->nickname == $nickname )
			{
				unset($json->users[$i]);
				
				// rebase the array
				$json->users = array_values($json->users);
				
				file_put_contents($fileName, json_encode($json));
				return;
			}
			++$i;
		}
	}
}

function usersExists($nickname)
{
	$fileName = getUsersFilePath();
	
	if( file_exists($fileName) )
	{
		$json = json_decode(file_get_contents($fileName));
		
		foreach( $json->users as $item )
		{
			if( $item->nickname == $nickname )
			{
				return true;
			}
		}
	}
	
	return false;
}

function getAllUsers()
{
	$usersName = array();
	
	$fileName = getUsersFilePath();
	
	if( file_exists($fileName) )
	{
		$json = json_decode(file_get_contents($fileName));
		
		foreach( $json->users as $item )
		{
			array_push($usersName, $item->nickname);
		}
	}
	
	return $usersName;
}

?>
