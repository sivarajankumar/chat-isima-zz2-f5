<?php

	require 'usersManager.php';

	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		$usersManager = new UsersManager( getUsersFilePath() );
		$usersManager->updateTimespan($_SESSION['nickname']);
		echo json_encode( $usersManager->getAllUsers() );
	}
	
?>