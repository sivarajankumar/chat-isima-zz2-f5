<?php

	require 'messagesManager.php';

	session_start();
	
	$filePath = getMessagesFilePath();
	
	$msgManager = new MessagesManager($filePath);
	
	$data	= array();	// array to pass back data
	
	if( isset($_SESSION['nickname']) )
	{
		$nickname = 'home';
		echo json_encode($msgManager->getMessages($nickname));
	}

?>