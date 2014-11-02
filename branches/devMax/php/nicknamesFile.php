<?php

function getNicknamePath()
{
	// Analyse sans sections
	$config_array = parse_ini_file("configuration.ini");
	
	return $config_array["nicknamePath"];
}

function addNickname($nickname)
{
	$fileName = getNicknamePath();
	
	if( ! file_exists($fileName) )
	{
		// Create or read file $fileName
		$file = fopen($fileName, 'c');
		
		$username[] = array('nickname' => $nickname);
		$data['usernames'] = $username;
		
		fwrite($file, json_encode($data));
		fclose($file);
	}
	else
	{
		$json = json_decode(file_get_contents($fileName), true);
		
		array_push($json['usernames'], array('nickname' => $nickname));
		
		file_put_contents($fileName, json_encode($json));
	}
}

function removeNickname($nickname)
{
	$fileName = getNicknamePath();
	
	if( file_exists($fileName) )
	{
		$json = json_decode(file_get_contents($fileName));
		
		$i = 0;
		foreach( $json->usernames as $item )
		{
			if( $item->nickname == $nickname )
			{
				unset($json->usernames[$i]);
				file_put_contents($fileName, json_encode($json));
				return;
			}
			++$i;
		}
	}
}

function nicknameExists($nickname)
{
	$fileName = getNicknamePath();
	
	if( file_exists($fileName) )
	{
		$json = json_decode(file_get_contents($fileName));
		
		foreach( $json->usernames as $item )
		{
			if( $item->nickname == $nickname )
			{
				return true;
			}
		}
	}
	
	return false;
}

?>