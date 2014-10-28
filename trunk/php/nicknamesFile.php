<?php

function addNickname($nickname)
{
	$fileName = "datas/nicknames.json";
	
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
	
}

function nicknameExists($nickname)
{
	$fileName = "datas/nicknames.json";
	
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