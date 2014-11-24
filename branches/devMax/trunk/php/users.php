<?php

	require 'usersManager.php';

	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		echo json_encode(getAllUsers());
	}
	
?>