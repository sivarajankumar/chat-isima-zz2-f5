<?php
	require 'usersManager.php';
	
	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		$usersManager = new UsersManager( getUsersFilePath() );
		$usersManager->removeUsers($_SESSION['nickname']);
		unset($_SESSION['nickname']);
	}
?>