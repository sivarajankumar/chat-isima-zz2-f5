<?php

	require 'messagesManager.php';

	session_start();
	
	$data	= array();	// array to pass back data
	
	if( isset($_SESSION['nickname']) )
	{
		$nickname = 'chat';
		echo json_encode(getMessages($nickname));
	}

?>