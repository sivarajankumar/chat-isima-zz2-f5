<?php

	require 'usersManager.php';
	
	session_start();
	
	$requestMethod = $_SERVER['REQUEST_METHOD'];
	
	$data	= array();	// array to pass back data
	
	switch($requestMethod)
	{
		case 'GET' :
			if( !isset($_SESSION['nickname']) )
				$data['nickname'] = "";
			else
				$data['nickname'] = $_SESSION['nickname'];
			break;
		case 'DELETE' :
			if( isset($_SESSION['nickname']) )
			{
				$usersManager = new UsersManager( getUsersFilePath() );
				$usersManager->removeUsers($_SESSION['nickname']);
				unset($_SESSION['nickname']);
				$data['success'] = true;
			}
			break;
		default:
			break;
	}
	
	echo json_encode($data);

?>