<?php

class UsersManager
{
	protected $fileName;

	public function __construct($fileName)
	{
		$this->fileName = $fileName;
		
		// Définit le fuseau horaire par défaut à utiliser.
		date_default_timezone_set('UTC');
	}
	
	public function addUsers($nickname, $password)
	{	
		if( ! file_exists($this->fileName) )
		{
			// Create or read file $fileName
			$file = fopen($this->fileName, 'c');
	
			$username[] = array('nickname' => $nickname, 'password' => $password, 'date' => date("Y-m-d H:i:s"));
			$data['users'] = $username;
	
			fwrite($file, json_encode($data));
			fclose($file);
		}
		else
		{
			$json = json_decode(file_get_contents($this->fileName), true);
	
			array_push($json['users'], array('nickname' => $nickname, 'password' => $password, 'date' => date("Y-m-d H:i:s")));
	
			file_put_contents($this->fileName, json_encode($json));
		}
	}
	
	public function removeUsers($nickname)
	{	
		if( file_exists($this->fileName) )
		{
			$json = json_decode(file_get_contents($this->fileName));
	
			$i = 0;
			foreach( $json->users as $item )
			{
				if( $item->nickname == $nickname )
				{
					unset($json->users[$i]);
	
					// rebase the array
					$json->users = array_values($json->users);
	
					file_put_contents($this->fileName, json_encode($json));
					return;
				}
				++$i;
			}
		}
	}
	
	public function usersExists($nickname)
	{
		if( file_exists($this->fileName) )
		{
			$json = json_decode(file_get_contents($this->fileName));
	
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
	
	public function verifyPassword($nickname, $password)
	{	
		if( file_exists($this->fileName) )
		{
			$json = json_decode(file_get_contents($this->fileName));
	
			foreach( $json->users as $item )
			{
				if( $item->nickname == $nickname )
				{
					if( $item->password == $password )
						return true;
					else
						return false;
				}
			}
		}
	
		return false;
	}
	
	public function updateTimespan($nickname)
	{
		if( file_exists($this->fileName) )
		{
			$json = json_decode(file_get_contents($this->fileName));
			
			foreach( $json->users as $item )
			{
				if( $item->nickname == $nickname )
				{
					$item->date = date("Y-m-d H:i:s");
				}
				else
				{
					if( $item->password == false )
					{
						
					}
				}
			}
		}
		file_put_contents($this->fileName, json_encode($json));
	}
	
	public function getAllUsers()
	{
		$usersName = array();
		
		if( file_exists($this->fileName) )
		{
			$json = json_decode(file_get_contents($this->fileName));
	
			foreach( $json->users as $item )
			{
				$date		= new DateTime( $item->date );
				$date->modify('+10 minutes');
				$dateToEnd	= $date->format("YmdHis");
				$currentDate = new DateTime( date("YmdHis") );
				$currentDate = $currentDate->format("YmdHis");
			
				if( $currentDate <= $dateToEnd )
					array_push($usersName, $item->nickname);
			}
		}
	
		return $usersName;
	}
}

function getUsersFilePath()
{
	// Analyse sans sections
	$config_array = parse_ini_file("configuration.ini");
	
	return $config_array["usersFilePath"];
}



?>
