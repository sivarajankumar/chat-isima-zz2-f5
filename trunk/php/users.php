<?php

	require 'usersManager.php';

	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		$usersManager = new UsersManager( getUsersFilePath() );
		echo json_encode( $usersManager->getAllUsers() );
	}
	
?>