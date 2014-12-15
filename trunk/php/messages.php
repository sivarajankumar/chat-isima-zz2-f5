<?php

	require 'messagesManager.php';

	session_start();
	
	$requestMethod = $_SERVER['REQUEST_METHOD'];
	
	$data	= array();	// array to pass back data
	
	if( isset($_SESSION['nickname']) )
	{
		$messagesManager = new MessagesManager( getMessagesFilePath() );
		
		switch($requestMethod)
		{
			case 'POST' :
				echo "Ajout message";
				
				if( isset($_POST['receiver']) && isset($_POST['message']) )
				{
					$owner		= $_SESSION['nickname'];
					$receiver	= $_POST['receiver'];
					$message	= $_POST['message'];
					
					if( ! empty($owner) && ! empty($receiver) && ! empty($message) )
					{
						$messagesManager->addMessage($owner, $receiver, $message);
					}
					else 
					{
						$data['error'] = "Some fileds are empty";
					}
				}
				else
				{
					$data['error'] = "Some fileds are missing";
				}
				break;
			case 'GET' :
				echo "Liste des messages";
				break;
			case 'delete' :
				echo "Suppression des messages";
				break;
		}
	}
	else 
	{
		$data['error'] = "You are not allowed to access this page";
	}
	
	echo json_encode($data);

?>