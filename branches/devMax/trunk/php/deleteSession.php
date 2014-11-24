<?php
	require 'usersManager.php';
	
	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		removeUsers($_SESSION['nickname']);
		unset($_SESSION['nickname']);
	}
?>